<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Teacher, Subject, TeacherSubject};
use Carbon\Carbon;

class TeacherSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();

        if ($teachers->isEmpty() || $subjects->isEmpty()) {
            $this->command->warn('⚠️ Teachers and subjects are required for TeacherSubjectSeeder.');
            return;
        }

        $subjectIds = $subjects->pluck('id')->toArray();
        $createdCount = 0;

        foreach ($teachers as $teacher) {
            $numSubjects = rand(2, 4);
            $assignedSubjects = array_rand($subjectIds, min($numSubjects, count($subjectIds)));
            
            if (!is_array($assignedSubjects)) {
                $assignedSubjects = [$assignedSubjects];
            }

            foreach ($assignedSubjects as $subjectId) {
                if (TeacherSubject::where('teacher_id', $teacher->id)
                    ->where('subject_id', $subjectIds[$subjectId])
                    ->exists()) {
                    continue;
                }

                TeacherSubject::create([
                    'teacher_id' => $teacher->id,
                    'subject_id' => $subjectIds[$subjectId],
                    'started_at' => Carbon::now(),
                    'ended_at' => Carbon::now()->addMonths(rand(6, 24)),
                ]);

                $createdCount++;
            }
        }

        $this->command->info("✅ TeacherSubjectSeeder berhasil membuat {$createdCount} penugasan guru-mata pelajaran.");
    }
}
