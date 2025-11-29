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

        // ====== GURU (200 orang) ======
        // Use factory to generate names and emails
        User::factory()
            ->count(200)
            ->asTeacher()
            ->create([ 'password' => 'guru123' ]);

        // ====== SISWA (000 orang) ======
        User::factory()
            ->count(3000)
            ->asStudent()
            ->create([ 'password' => 'siswa123' ]);

        // ====== STAFF (optional, 5 orang) ======
        User::factory()
            ->count(5)
            ->asStaff()
            ->create([ 'password' => 'staff123' ]);

        $this->command->info('✅ UserSeeder berhasil membuat:
        - 1 Admin
        - 200 Guru
        - 3000 Siswa
        - 5 Staff');
    }
}
