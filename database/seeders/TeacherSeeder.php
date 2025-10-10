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

            // Buat staff_id unik (misal T001, T002, dst)
            $staffId = 'T' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

            // Pilih 1–3 mata pelajaran acak
            $assignedSubjects = $faker->randomElements($subjects, rand(1, 3));

            // Jadwal tersedia acak
            $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
            $available = [];
            for ($i = 0; $i < rand(2, 4); $i++) {
                $day = $faker->randomElement($days);
                $start = $faker->randomElement(['07:00', '08:00', '09:00']);
                $end = $faker->randomElement(['10:00', '11:00', '12:00']);
                $available[] = "{$day} {$start}-{$end}";
            }

            Teacher::create([
                'staff_id' => $staffId,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $faker->unique()->phoneNumber(),
                'subjects' => $assignedSubjects,
                'available_hours' => array_values(array_unique($available)),
                'user_id' => $user->id,
            ]);
        }

        $this->command->info('✅ TeacherSeeder berhasil membuat data guru berdasarkan user role Guru (' . $teachers->count() . ' orang).');
    }
}
