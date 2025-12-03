<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Classroom, Teacher, Major, Term};

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        // Historically classes had a term_id column, but the latest schema uses
        // timetable templates/assignments to represent active terms per class.

        $majors = Major::all();

        if ($majors->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada jurusan di database. Jalankan MajorSeeder dulu.');
            return;
        }

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
                        ]
                    );
                }
            }
        }

        $total = $majors->count() * 3 * $rombelPerLevel;

        $this->command->info("✅ Berhasil membuat {$total} kelas untuk {$majors->count()} jurusan (tiap level 10-12, {$rombelPerLevel} rombel).");
    }
}
