<?php

namespace App\Http\Controllers\Staff\Student;

use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    /**
     * Download student import template.
     */
    public function __invoke()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=students_template.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Name', 'Email', 'Password', 'NIS', 'NISN', 'Classroom (e.g. 10 PPLG 1)'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Add example row
            fputcsv($file, ['John Doe', 'john@example.com', '1234567890', '2324567890', '0012345678', '10 PPLG 1']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
