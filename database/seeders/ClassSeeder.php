<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassRoom;
use App\Models\Teacher;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $teacher = Teacher::where('name', 'Andi Setiawan, S.Kom')->first();

        ClassRoom::create([
            'name' => '12 RPL 1',
            'level' => 12,
            'academic_year' => '2025/2026',
            'homeroom_teacher_id' => $teacher ? $teacher->id : null
        ]);
    }
}
