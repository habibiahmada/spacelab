<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('name', 'Administrator')->first();
        $subject = Subject::where('name', 'Pemrograman Web')->first();

        Teacher::create([
            'staff_id' => 'T001',
            'name' => 'Andi Setiawan, S.Kom',
            'email' => 'andi@ilab.sch.id',
            'phone' => '081234567890',
            'subjects' => [$subject?->id], // biarkan sebagai array, Laravel akan cast ke JSON
            'available_hours' => ['Mon 08:00-12:00', 'Wed 08:00-10:00'],
            'user_id' => $user?->id,
        ]);
    }
}
