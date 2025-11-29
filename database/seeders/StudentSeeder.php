<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Student, Classroom, User, Role};
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

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
            $nis = str_pad($counter, 8, '0', STR_PAD_LEFT);
            $nisn = '00' . str_pad($counter, 8, '0', STR_PAD_LEFT);

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

            $counter++;
        }

        $this->command->info("✅ StudentSeeder berhasil membuat/menyesuaikan {$studentUsers->count()} siswa dari tabel users.");
    }
}
