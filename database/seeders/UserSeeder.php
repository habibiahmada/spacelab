<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // ====== ADMIN ======
        $adminRole = Role::where('name', 'Admin')->first();
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@ilab.sch.id',
            'password_hash' => Hash::make('admin123'),
            'role_id' => $adminRole?->id,
        ]);

        // ====== GURU (50 orang) ======
        $teacherRole = Role::where('name', 'Guru')->first();
        for ($i = 1; $i <= 200; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => "guru{$i}@ilab.sch.id",
                'password_hash' => Hash::make('guru123'),
                'role_id' => $teacherRole?->id,
            ]);
        }

        // ====== SISWA (3000 orang) ======
        $studentRole = Role::where('name', 'Siswa')->first();
        for ($i = 1; $i <= 3000; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => "siswa{$i}@ilab.sch.id",
                'password_hash' => Hash::make('siswa123'),
                'role_id' => $studentRole?->id,
            ]);
        }

        // ====== STAFF (optional, 5 orang) ======
        $staffRole = Role::where('name', 'Staff')->first();
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => "staff{$i}@ilab.sch.id",
                'password_hash' => Hash::make('staff123'),
                'role_id' => $staffRole?->id,
            ]);
        }

        $this->command->info('✅ UserSeeder berhasil membuat:
        - 1 Admin
        - 50 Guru
        - 3000 Siswa
        - 5 Staff');
    }
}
