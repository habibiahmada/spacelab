<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Support\Arr;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {

        $user = User::where('name', 'Administrator')->first();
        $subject = Subject::where('name', 'Pemrograman Web')->first();
        $now = now();

        Teacher::insert([
            [
                'id' => (string) Str::uuid(),
                'staff_id' => 'T001',
                'name' => 'Andi Setiawan, S.Kom',
                'email' => 'andi@ilab.sch.id',
                'phone' => '081234567890',
                'subjects' => json_encode([$subject ? $subject->id : null]),
                'available_hours' => json_encode(['Mon 08:00-12:00', 'Wed 08:00-10:00']),
                'user_id' => $user ? $user->id : null,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}
