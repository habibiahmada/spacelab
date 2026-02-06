<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    /**
     * Download teacher import template.
     */
    public function __invoke()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=teachers_template.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Name', 'Email', 'Password', 'Code', 'Phone'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Add example row
            fputcsv($file, ['John Doe', 'john.teacher@example.com', 'password123', 'JD001', '081234567890']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
