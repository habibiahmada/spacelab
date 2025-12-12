<?php

namespace App\Http\Controllers\Staff\Classroom;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Major;

class TemplateController extends Controller
{
    /**
     * Download classroom import template.
     */
    public function __invoke(Request $request)
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=classrooms_template.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['level', 'kode jurusan', 'rombel'];

        $majorCode = 'RPL';
        if ($request->has('major_id')) {
            $major = Major::find($request->major_id);
            if ($major) {
                $majorCode = $major->code;
            }
        }

        $callback = function () use ($columns, $majorCode) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Example row
            fputcsv($file, ['10', $majorCode, '1']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
