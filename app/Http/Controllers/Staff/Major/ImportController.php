<?php

namespace App\Http\Controllers\Staff\Major;

use App\Http\Controllers\Controller;
use App\Models\Major;
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

        try {
            DB::beginTransaction();

            // Detect delimiter from first line (handles Excel which may use semicolon)
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

                // Ensure we have at least the expected number of columns
                if (count($row) < 2) continue;

                // Normalize fields (trim and remove BOM from first column)
                $row = array_map(function ($v) {
                    if (is_null($v)) return null;
                    $v = trim($v);
                    // remove UTF-8 BOM if present
                    $v = preg_replace('/^\xEF\xBB\xBF/', '', $v);
                    return $v;
                }, $row);

                // Map columns (allow files with fewer/more columns)
                $code = $row[0] ?? null;
                $name = $row[1] ?? null;
                $description = $row[2] ?? null;
                $logo = $row[3] ?? null;
                $website = $row[4] ?? null;
                $contactEmail = $row[5] ?? null;
                $slogan = $row[6] ?? null;

                // Basic validation: require code and name
                if (empty($code) || empty($name)) {
                    continue;
                }

                // Skip duplicates
                if (Major::where('name', $name)->exists() || Major::where('code', $code)->exists()) {
                    continue;
                }

                Major::create([
                    'code' => $code,
                    'name' => $name,
                    'description' => $description,
                    'logo' => $logo,
                    'website' => $website,
                    'contact_email' => $contactEmail,
                    'slogan' => $slogan,
                ]);
            }

            DB::commit();
            fclose($handle);
            return redirect()->back()->with('success', 'Jurusan berhasil diimport.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle)) fclose($handle);
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
