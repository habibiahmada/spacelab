<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
            'permissions' => ['manage_users', 'manage_schedule', 'view_reports'],
        ]);

        Role::create([
            'name' => 'Guru',
            'permissions' => ['view_schedule', 'manage_class'],
        ]);

        Role::create([
            'name' => 'Siswa',
            'permissions' => ['view_schedule'],
        ]);
    }
}
