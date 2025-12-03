<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Student, User, Role};

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $studentRole = Role::where('name', 'Siswa')->first();
        if (! $studentRole) {
            $this->command->warn('⚠️ Role "Siswa" belum ada. Jalankan RoleSeeder dulu.');
            return;
        }

        $studentUsers = User::where('role_id', $studentRole->id)->get();

        if ($studentUsers->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada user berrole Siswa. Jalankan UserSeeder dulu.');
            return;
        }

        $this->command->info("ℹ️ Menyinkronkan tabel students untuk {$studentUsers->count()} user siswa.");

        $i = 1;
        foreach ($studentUsers as $user) {
            $nis = str_pad($i, 8, '0', STR_PAD_LEFT);
            $nisn = '00' . str_pad($i, 8, '0', STR_PAD_LEFT);

            $hash = crc32($user->id);
            $index = $hash % 100;
            $gender = ($hash % 2 === 0) ? 'men' : 'women';
            $avatarUrl = "https://randomuser.me/api/portraits/{$gender}/{$index}.jpg";

            Student::updateOrCreate(
                ['users_id' => $user->id],
                [
                    'nis' => $nis,
                    'nisn' => $nisn,
                    'avatar' => $avatarUrl,
                ]
            );

            $i++;
        }

        $this->command->info('✅ StudentSink: selesai.');
    }
}
