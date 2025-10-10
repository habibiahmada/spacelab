<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Student, Classroom, User, Role};
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua user dengan role "Siswa"
        $studentRole = Role::where('name', 'Siswa')->first();

        if (! $studentRole) {
            $this->command->warn('⚠️ Role "Siswa" belum ada. Jalankan RoleSeeder dulu.');
            return;
        }

        $studentUsers = User::where('role_id', $studentRole->id)->get();
        $classes = Classroom::all();

        if ($classes->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada kelas di database. Jalankan ClassSeeder dulu.');
            return;
        }

        $counter = 1;
        foreach ($studentUsers as $user) {
            $class = $classes->random();

            // Buat NIS dan NISN unik berbasis counter
            $nis = str_pad($counter, 8, '0', STR_PAD_LEFT);
            $nisn = '00' . str_pad($counter, 8, '0', STR_PAD_LEFT);

            Student::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nis' => $nis,
                    'nisn' => $nisn,
                    'class_id' => $class->id,
                    'guardian_name' => $faker->name('male'),
                    'phone' => $faker->unique()->numerify('08##########'),
                ]
            );

            $counter++;
        }

        $this->command->info("✅ StudentSeeder berhasil membuat/menyesuaikan {$studentUsers->count()} siswa dari tabel users.");
    }
}