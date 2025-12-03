<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Classroom, Teacher, User, Subject};
use Faker\Factory as Faker;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $teachers = User::whereHas('role', fn($q) => $q->where('name', 'Guru'))->get();

        // If there are fewer teachers than classes, create additional users with role Guru
        $classesCount = Classroom::count();
        $currentTeacherCount = $teachers->count();
        if ($currentTeacherCount < $classesCount) {
            $needed = $classesCount - $currentTeacherCount;
            $this->command->info("⚠️ Not enough teachers. Creating {$needed} additional teacher users.");
            // Use User factory to create more teacher users
            User::factory()
                ->count($needed)
                ->asTeacher()
                ->create([ 'password' => 'guru123' ]);

            // Refresh teachers collection
            $teachers = User::whereHas('role', fn($q) => $q->where('name', 'Guru'))->get();
            $currentTeacherCount = $teachers->count();
        }

        // Ambil semua mata pelajaran untuk diacak

        if ($teachers->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada user dengan role Guru. Jalankan UserSeeder dulu.');
            return;
        }

        foreach ($teachers as $index => $user) {
            // Pastikan tidak membuat duplikat teacher
            if (Teacher::where('user_id', $user->id)->exists()) {
                continue;
            }

            // Teacher table now expects `code`, `phone`, `avatar` and `user_id`.
            // Build a code like T-001
            $code = 'T-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

            $avatar = 'https://i.pravatar.cc/300?img=' . rand(1, 70);

            Teacher::create([
                'code' => $code,
                'phone' => $faker->unique()->phoneNumber(),
                'avatar' => $avatar,
                'user_id' => $user->id,
            ]);
        }

        $this->command->info('✅ TeacherSeeder berhasil membuat data guru berdasarkan user role Guru (' . $teachers->count() . ' orang).');
    }
}
