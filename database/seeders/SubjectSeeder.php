<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        Subject::create([
            'code' => 'RPL101',
            'name' => 'Pemrograman Web',
            'type' => 'praktikum',
            'description' => 'Belajar membuat aplikasi berbasis web menggunakan Laravel.',
        ]);

        Subject::create([
            'code' => 'MTK101',
            'name' => 'Matematika',
            'type' => 'teori',
            'description' => 'Pelajaran dasar dan lanjutan matematika SMK.',
        ]);
    }
}
