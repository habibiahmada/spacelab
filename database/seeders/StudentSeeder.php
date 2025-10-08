<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\User;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $class = ClassRoom::where('name', '12 RPL 1')->first();
        $user = User::where('name', 'Habib Ahmad A.')->first();

        Student::create([
            'nis' => '12230101',
            'nisn' => '0065432101',
            'name' => 'Habib Ahmad A.',
            'class_id' => $class ? $class->id : null,
            'guardian_name' => 'Ahmad Yusuf',
            'phone' => '081234500111',
            'user_id' => $user ? $user->id : null
        ]);
    }
}
