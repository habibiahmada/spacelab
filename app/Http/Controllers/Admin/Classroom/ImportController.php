<?php

namespace App\Http\Controllers\Admin\Classroom;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    /**
     * Import classrooms from CSV.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
            'major_id' => 'required|exists:majors,id',
        ], [
            'file.required' => 'File is required.',
            'file.mimes' => 'File must be a CSV or TXT file.',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');
        $selectedMajor = Major::find($request->major_id);
        $importedCount = 0;

        try {
            DB::beginTransaction();

            // Detect delimiter from first line
            $firstLine = fgets($handle);
            rewind($handle);
            $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

            $isHeader = true;

            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                // Skip empty rows
                if ($row === [null] || count($row) === 0) continue;

                // Skip header
                if ($isHeader) {
                    $isHeader = false;
                    continue;
                }

                // Normalize fields
                $row = array_map(function ($v) {
                    if (is_null($v)) return null;
                    $v = trim($v);
                    // remove BOM
                    $v = preg_replace('/^\xEF\xBB\xBF/', '', $v);
                    // Replace doubled quotes from Excel exports
                    $v = str_replace('""', '"', $v);
                    // Remove surrounding quotes
                    $v = preg_replace('/^\"|\"$/', '', $v);
                    return $v;
                }, $row);

                // Map expected columns: level, major_code, rombel
                $level = $row[0] ?? null;
                $majorCode = $row[1] ?? null;
                $rombel = $row[2] ?? null;

                if (empty($level) || empty($majorCode) || empty($rombel)) {
                    continue;
                }

                // Check if the major code in CSV matches the selected major (case-insensitive)
                if (strcasecmp($majorCode, $selectedMajor->code) !== 0) {
                    // Skip if major code does not match the selected major
                    continue;
                }

                // Find major by code - strictly ensure it matches the selected major
                // Although we checked code above, using the object ensures we use the correct ID
                $major = $selectedMajor;

                // Skip duplicate classroom
                $exists = Classroom::where('level', $level)
                    ->where('major_id', $major->id)
                    ->where('rombel', $rombel)
                    ->exists();

                if ($exists) continue;

                Classroom::create([
                    'level' => $level,
                    'major_id' => $major->id,
                    'rombel' => $rombel,
                ]);
                $importedCount++;
            }

            DB::commit();
            fclose($handle);

            if ($importedCount === 0) {
                return redirect()->back()->with('error', 'Tidak ada data yang diimport. Pastikan kode jurusan di CSV sesuai (' . $selectedMajor->code . ') atau data belum ada di database.');
            }

            return redirect()->back()->with('success', $importedCount . ' kelas berhasil diimport.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle)) fclose($handle);
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
