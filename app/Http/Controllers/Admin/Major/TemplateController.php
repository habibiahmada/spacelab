<?php

namespace App\Http\Controllers\Admin\Major;

use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    /**
     * Download major import template.
     */
    public function __invoke()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=majors_template.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['code', 'name', 'description', 'logo', 'website', 'contact_email', 'slogan'];


        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Add example row
            fputcsv($file, ['RPL', 'Rekayasa Perangkat Lunak', 'Fokus pada pengembangan perangkat lunak berbasis desktop, web, dan mobile.', '', 'https://rpl.smkn1karawang.sch.id', 'pplg.smkn1karawang@gmail.com', 'Be Adaptive, Creative and Inovative']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
