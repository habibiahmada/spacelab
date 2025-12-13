<?php

namespace App\Http\Controllers\Staff\Student;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\ClassHistory;
use App\Models\Classroom;
use App\Models\Role;
use App\Models\Student;
use App\Models\Term;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    /**
     * Import students from CSV.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');

        // Detect delimiter
        $firstLine = fgets($handle);
        rewind($handle);
        $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';

        // Skip header
        fgetcsv($handle, 0, $delimiter);

        DB::beginTransaction();

        try {
            $activeTerm = Term::where('is_active', true)->firstOrFail();
            $role = Role::where('name', 'Siswa')->firstOrFail();

            // Find the current active block based on today's date
            $today = now()->toDateString();
            $activeBlock = Block::where('terms_id', $activeTerm->id)
                ->where('start_date', '<=', $today)
                ->where('end_date', '>=', $today)
                ->first();

            // If no active block found, get the first block of the term
            if (!$activeBlock) {
                $activeBlock = Block::where('terms_id', $activeTerm->id)
                    ->orderBy('start_date')
                    ->first();
            }

            if (!$activeBlock) {
                throw new \Exception('Tidak ada blok yang tersedia untuk term aktif. Silakan buat blok terlebih dahulu.');
            }

            $imported = 0;
            $skipped = 0;

            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {

                if (count($row) < 6) {
                    $skipped++;
                    continue;
                }

                [
                    $name,
                    $email,
                    $password,
                    $nis,
                    $nisn,
                    $classroomName
                ] = array_map('trim', $row);

                // Clean weird triple quotes
                $classroomName = trim($classroomName);
                $classroomName = preg_replace('/^"+|"+$/', '', $classroomName);

                // Skip duplicate
                if (
                    User::where('email', $email)->exists() ||
                    Student::where('nisn', $nisn)->exists()
                ) {
                    $skipped++;
                    continue;
                }

                // Parse classroom: "10 RPL 1"
                $parts = preg_split('/\s+/', $classroomName);

                if (count($parts) < 3) {
                    $skipped++;
                    continue;
                }

                [$level, $majorCode, $rombel] = $parts;

                $class = Classroom::where('level', $level)
                    ->where('rombel', $rombel)
                    ->whereHas('major', fn ($q) => $q->where('code', $majorCode))
                    ->first();

                if (!$class) {
                    $skipped++;
                    continue;
                }

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password_hash' => bcrypt($password),
                    'role_id' => $role->id,
                ]);

                $student = Student::create([
                    'users_id' => $user->id,
                    'nis' => $nis,
                    'nisn' => $nisn,
                ]);

                ClassHistory::create([
                    'student_id' => $student->id,
                    'class_id' => $class->id,
                    'terms_id' => $activeTerm->id,
                    'block_id' => $activeBlock->id,
                ]);

                $imported++;
            }

            DB::commit();
            fclose($handle);

            return back()->with(
                'success',
                "Import selesai. Berhasil: {$imported}, Dilewati: {$skipped}"
            );

        } catch (\Throwable $e) {
            DB::rollBack();
            fclose($handle);

            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

}
