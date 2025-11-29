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

        // ====== GURU (20 orang) ======
        // Use factory to generate names and emails
        User::factory()
            ->count(20)
            ->asTeacher()
            ->create([ 'password' => 'guru123' ]);
        
        $gururole = Role::where('name', 'Guru')->first();
        User::create([
            'name' => 'Guru Contoh',
            'email' => 'guru@ilab.sch.id',
            'password_hash' => Hash::make('guru123'),
            'role_id' => $gururole?->id,
        ]);

        // ====== SISWA (300 orang) ======
        User::factory()
            ->count(300)
            ->asStudent()
            ->create([ 'password' => 'siswa123' ]);

        $studentRole = Role::where('name', 'Siswa')->first();
        User::create([
            'name' => 'Siswa Contoh',
            'email' => 'siswa@ilab.sch.id',
            'password_hash' => Hash::make('siswa123'),
            'role_id' => $studentRole?->id,
        ]);

        // ====== STAFF (optional, 5 orang) ======
        User::factory()
            ->count(5)
            ->asStaff()
            ->create([ 'password' => 'staff123' ]);

        $staffRole = Role::where('name', 'Staff')->first();
        User::create([
            'name' => 'Staff Contoh',
            'email' => 'staff@ilab.sch.id',
            'password_hash' => Hash::make('staff123'),
            'role_id' => $staffRole?->id,
        ]);

        $this->command->info('✅ UserSeeder berhasil membuat:
        - 1 Admin
        - 20 Guru
        - 300 Siswa
        - 5 Staff');
    }
}
