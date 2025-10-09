<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\User;
use App\Models\Major;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Temukan jurusan RPL
        $major = Major::where('code', 'RPL')->first();

        // Temukan kelas berdasarkan kombinasi level, major_id, dan rombel
        $class = Classroom::where('level', 10)
            ->where('rombel', 1)
            ->where('major_id', $major?->id)
            ->first();

        // Temukan user
        $user = User::where('name', 'Habib Ahmad A.')->first();

        Student::create([
            'nis' => '12230101',
            'nisn' => '0065432101',
            'name' => 'Habib Ahmad A.',
            'class_id' => $class?->id,
            'guardian_name' => 'Ahmad Yusuf',
            'phone' => '081234500111',
            'user_id' => $user?->id,
        ]);
    }
}