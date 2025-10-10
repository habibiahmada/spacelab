<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{ClassRoom, Teacher, Major, Term};
use Illuminate\Support\Arr;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $term = Term::where('is_active', true)->first();

        if (! $term) {
            $this->command->warn('⚠️ Tidak ada term aktif. Jalankan TermSeeder dulu.');
            return;
        }

        $majors = Major::all();

        if ($majors->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada jurusan di database. Jalankan MajorSeeder dulu.');
            return;
        }

        $teachers = Teacher::all();

        // Jumlah rombel per level
        $rombelPerLevel = 3; // ubah sesuai kebutuhan

        foreach ($majors as $major) {
            foreach ([10, 11, 12] as $level) {
                for ($rombel = 1; $rombel <= $rombelPerLevel; $rombel++) {
                    ClassRoom::updateOrCreate(
                        [
                            'level' => $level,
                            'rombel' => (string) $rombel,
                            'major_id' => $major->id,
                        ],
                        [
                            'term_id' => $term->id,
                            // acak wali kelas dari daftar guru
                            'homeroom_teacher_id' => $teachers->random()?->id,
                        ]
                    );
                }
            }
        }

        $total = $majors->count() * 3 * $rombelPerLevel;

        $this->command->info("✅ Berhasil membuat {$total} kelas untuk {$majors->count()} jurusan (tiap level 10–12, {$rombelPerLevel} rombel).");
    }
}
