<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $role = Role::where('name', 'Admin')->first();

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@ilab.sch.id',
            'password_hash' => Hash::make('admin123'),
            'role_id' => $role ? $role->id : null,
        ]);

        $role = Role::where('name', 'Guru')->first();

        User::create([
            'name' => 'Guru',
            'email' => 'guru@ilab.sch.id',
            'password_hash' => Hash::make('guru123'),
            'role_id' => $role ? $role->id : null,
        ]);

        $role = Role::where('name', 'Siswa')->first();

        User::create([
            'name' => 'Siswa',
            'email' => 'siswa@ilab.sch.id',
            'password_hash' => Hash::make('siswa123'),
            'role_id' => $role ? $role->id : null,
        ]);

    }
}
