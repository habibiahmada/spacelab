<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        Role::insert([
            [
                'id' => (string) Str::uuid(),
                'name' => 'Admin',
                'permissions' => json_encode(['manage_users', 'manage_schedule', 'view_reports']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Guru',
                'permissions' => json_encode(['view_schedule', 'manage_class']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Siswa',
                'permissions' => json_encode(['view_schedule']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
