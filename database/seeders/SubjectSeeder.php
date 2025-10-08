<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use Illuminate\Support\Str;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        Subject::insert([
            [
                'id' => (string) Str::uuid(),
                'code' => 'RPL101',
                'name' => 'Pemrograman Web',
                'type' => 'praktikum',
                'description' => 'Belajar membuat aplikasi berbasis web menggunakan Laravel.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'code' => 'MTK101',
                'name' => 'Matematika',
                'type' => 'teori',
                'description' => 'Pelajaran dasar dan lanjutan matematika SMK.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
