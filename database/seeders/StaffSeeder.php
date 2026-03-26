<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil role Staff
        $staffRole = Role::where('name', 'Staff')->first();

        if (!$staffRole) {
            $this->command->error('Role Staff tidak ditemukan. Pastikan RoleSeeder sudah dijalankan.');
            return;
        }

        // Ambil semua user dengan role Staff
        $staffUsers = User::where('role_id', $staffRole->id)->get();

        if ($staffUsers->isEmpty()) {
            $this->command->info('Tidak ada user dengan role Staff ditemukan.');
            return;
        }

        // Type staff yang tersedia
        $staffTypes = ['ict', 'operator', 'curriculum', 'hubin', 'tu', 'sarpras', 'staff'];

        // Buat Staff record untuk setiap user
        foreach ($staffUsers as $index => $user) {
            // Assign type secara round-robin
            $type = $staffTypes[$index % count($staffTypes)];

            Staff::create([
                'user_id' => $user->id,
                'type' => $type,
            ]);
        }

        $this->command->info('✅ StaffSeeder berhasil membuat ' . $staffUsers->count() . ' staff records.');
    }
}
