<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{ClassHistory, Student, Classroom, Term, Block, User, Role};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ClassHistorySeeder extends Seeder
{
    public function run(): void
    {
        $classes = Classroom::all();
        $term = Term::where('is_active', true)->first() ?? Term::first();
        $blocks = Block::all();

        if ($classes->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada kelas. Pastikan ClassSeeder telah dijalankan.');
            return;
        }

        // Hitung total slot yang dibutuhkan (per kelas target 35, dikurangi yang sudah terisi untuk term ini)
        $totalNeeded = 0;
        foreach ($classes as $class) {
            $already = ClassHistory::where('class_id', $class->id)
                ->where('terms_id', $term->id)
                ->count();
            $needed = max(0, 35 - $already);
            $totalNeeded += $needed;
        }

        // Ambil students existing (model Student kamu pakai kolom users_id — kita ikuti itu)
        $students = Student::all();

        $this->command->info("ℹ️ Total slot kosong (semua kelas): {$totalNeeded}. Siswa existing: {$students->count()}.");

        // Jika students kurang, buat User ber-role "Siswa" dan buat entri Student untuk user baru tersebut
        if ($students->count() < $totalNeeded) {
            $missing = $totalNeeded - $students->count();
            $this->command->info("ℹ️ Membuat {$missing} user siswa baru (agar slot terisi).");

            // cari role Siswa
            $studentRole = Role::where('name', 'Siswa')->first();
            if (! $studentRole) {
                $this->command->warn('⚠️ Role "Siswa" belum tersedia. Buat Role "Siswa" terlebih dahulu.');
            } else {
                // create users in batch via factory if tersedia, kalau tidak fallback manual
                if (class_exists(\Database\Factories\UserFactory::class)) {
                    $newUsers = User::factory()
                        ->count($missing)
                        ->asStudent() // asumsikan factory state tersedia
                        ->create(['password' => 'siswa123']); // factory akan hash jika ada setter
                } else {
                    // fallback: buat manual (UUID id otomatis karena HasUuids)
                    $newUsers = collect();
                    for ($i = 0; $i < $missing; $i++) {
                        $u = User::create([
                            'name' => 'Siswa ' . Str::random(6),
                            'email' => 'siswa+' . Str::random(8) . '@example.test',
                            'password_hash' => Hash::make('siswa123'),
                            'role_id' => $studentRole->id,
                        ]);
                        $newUsers->push($u);
                    }
                }

                // Buat entri students untuk tiap new user (mengikuti pola StudentSeeder)
                $startIndex = Student::count() + 1;
                $i = $startIndex;
                foreach ($newUsers as $user) {
                    $nis = str_pad($i, 8, '0', STR_PAD_LEFT);
                    $nisn = '00' . str_pad($i, 8, '0', STR_PAD_LEFT);

                    // avatar random deterministic-ish
                    $hash = crc32($user->id);
                    $index = abs($hash) % 100;
                    $gender = ($hash % 2 === 0) ? 'men' : 'women';
                    $avatarUrl = "https://randomuser.me/api/portraits/{$gender}/{$index}.jpg";

                    // NOTE: model Student kamu nampak menggunakan kolom users_id (bukan user_id)
                    Student::create([
                        'nis' => $nis,
                        'nisn' => $nisn,
                        'users_id' => $user->id,
                        'avatar' => $avatarUrl,
                    ]);

                    $i++;
                }

                // reload students collection
                $students = Student::all();
                $this->command->info("✅ Menambahkan {$newUsers->count()} siswa baru dan entri students.");
            }
        }

        // shuffle students supaya distribusi acak
        $shuffled = $students->shuffle();
        $pointer = 0;

        foreach ($classes as $class) {
            $already = ClassHistory::where('class_id', $class->id)
                ->where('terms_id', $term->id)
                ->count();

            $needed = max(0, 35 - $already);
            if ($needed === 0) continue;

            $toAssign = $shuffled->slice($pointer, $needed);
            $pointer += $toAssign->count();

            if ($toAssign->isEmpty()) {
                $this->command->warn("⚠️ Siswa tidak cukup untuk mengisi Kelas {$class->id}. Terisi: {$already}. Diperlukan: {$needed}");
                continue;
            }

            foreach ($toAssign as $student) {
                // hindari duplikasi jika ada (safety)
                $exists = ClassHistory::where('student_id', $student->id)
                    ->where('class_id', $class->id)
                    ->where('terms_id', $term->id)
                    ->exists();
                if ($exists) continue;

                ClassHistory::create([
                    'student_id' => $student->id,
                    'class_id' => $class->id,
                    'terms_id' => $term->id,
                    'block_id' => $blocks->random()?->id,
                ]);
            }

            $this->command->info("✅ Kelas {$class->id}: ditambahkan {$toAssign->count()} siswa (target 35).");
        }

        $this->command->info('✅ ClassHistorySeeder selesai.');
    }
}
