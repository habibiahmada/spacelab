<?php

namespace App\Http\Controllers\Staff\Student;

use App\Http\Controllers\Controller;
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
        $header = fgetcsv($handle); // Skip header

        try {
            DB::beginTransaction();
            $activeTerm = Term::where('is_active', true)->firstOrFail();
            $role = Role::where('name', 'Student')->firstOrFail();
            $rowNumber = 1;

            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;
                if (count($row) < 5) continue; // Skip invalid rows

                [$name, $email, $nis, $nisn, $classroomName] = $row;

                // Simple validation check
                if (User::where('email', $email)->exists() || Student::where('nisn', $nisn)->exists()) {
                    continue; // Skip duplicates or handle error
                }

                // Find Class
                $parts = explode(' ', $classroomName);
                if (count($parts) >= 3) {
                    $level = $parts[0];
                    $majorCode = $parts[1];
                    $rombel = $parts[2];

                    $class = Classroom::where('level', $level)
                        ->where('rombel', $rombel)
                        ->whereHas('major', function ($q) use ($majorCode) {
                            $q->where('code', $majorCode);
                        })->first();
                } else {
                    $class = null;
                }

                if (!$class) {
                    continue;
                }

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $nisn,
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
                ]);
            }

            DB::commit();
            fclose($handle);
            return redirect()->back()->with('success', 'Students imported successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle)) fclose($handle);
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
