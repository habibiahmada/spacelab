<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $role = Role::where('name', 'Admin')->first();

        User::create([
            'id' => (string) Str::uuid(),
            'name' => 'Administrator',
            'email' => 'admin@ilab.sch.id',
            'password_hash' => Hash::make('admin123'),
            'role_id' => $role ? $role->id : null,
        ]);
    }
}
