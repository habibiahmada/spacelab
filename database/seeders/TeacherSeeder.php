<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Teacher, User, Subject};
use Faker\Factory as Faker;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua user dengan role guru
        $teachers = User::whereHas('role', fn($q) => $q->where('name', 'Guru'))->get();

        // Ambil semua mata pelajaran untuk diacak
        $subjects = Subject::pluck('id')->toArray();

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
