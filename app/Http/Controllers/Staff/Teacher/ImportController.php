<?php

namespace App\Http\Controllers\Staff\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    /**
     * Import teachers from CSV.
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
            $role = Role::where('name', 'Guru')->first();
            if (!$role) {
                $role = Role::create(['name' => 'Guru']);
            }

            $imported = 0;
            $skipped = 0;

            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                if (count($row) < 4) {
                    $skipped++;
                    continue;
                }

                [
                    $name,
                    $email,
                    $password,
                    $code,
                ] = array_map('trim', array_slice($row, 0, 4));

                // Get phone if exists
                $phone = isset($row[4]) ? trim($row[4]) : null;

                // Clean weird triple quotes
                $code = preg_replace('/^"+|"+$/', '', $code);

                // Skip if email already exists
                if (User::where('email', $email)->exists()) {
                    $skipped++;
                    continue;
                }

                // Skip if code already exists and is not empty
                if ($code && Teacher::where('code', $code)->exists()) {
                    $skipped++;
                    continue;
                }

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password_hash' => bcrypt($password),
                    'role_id' => $role->id,
                ]);

                Teacher::create([
                    'user_id' => $user->id,
                    'code' => $code ?: null,
                    'phone' => $phone ?: null,
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
