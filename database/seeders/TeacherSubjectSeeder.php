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

        // Ensure we have enough teachers - create more if needed for scheduling
        $classesCount = \App\Models\Classroom::count();
        $requiredTeachers = max($classesCount, 50); // At least 50 teachers

        if ($teachers->count() < $requiredTeachers) {
            $needed = $requiredTeachers - $teachers->count();
            $this->command->warn("⚠️ Creating {$needed} additional teacher users for scheduling flexibility.");

            $user = \App\Models\User::factory()
                ->count($needed)
                ->asTeacher()
                ->create(['password' => 'guru123']);

            // Create Teacher records for these new users
            foreach ($user as $u) {
                if (!Teacher::where('user_id', $u->id)->exists()) {
                    $code = 'T-' . str_pad($teachers->count() + 1, 3, '0', STR_PAD_LEFT);
                    Teacher::create([
                        'code' => $code,
                        'phone' => \Faker\Factory::create('id_ID')->unique()->phoneNumber(),
                        'avatar' => 'https://i.pravatar.cc/300?img=' . rand(1, 70),
                        'user_id' => $u->id,
                    ]);
                }
            }

            $teachers = Teacher::all();
        }

        $subjectIds = $subjects->pluck('id')->toArray();
        $createdCount = 0;
        $startedAt = Carbon::now();

        // Assign each teacher 4-6 subjects to give flexibility in scheduling
        foreach ($teachers as $teacher) {
            $numSubjects = rand(4, 6);
            $assignedSubjects = array_rand($subjectIds, min($numSubjects, count($subjectIds)));

            if (!is_array($assignedSubjects)) {
                $assignedSubjects = [$assignedSubjects];
            }

            foreach ($assignedSubjects as $subjectId) {
                $subjectIdValue = $subjectIds[$subjectId];

                if (TeacherSubject::where('teacher_id', $teacher->id)
                    ->where('subject_id', $subjectIdValue)
                    ->exists()) {
                    continue;
                }

                TeacherSubject::create([
                    'teacher_id' => $teacher->id,
                    'subject_id' => $subjectIdValue,
                    'started_at' => $startedAt,
                    'ended_at' => $startedAt->clone()->addYear(),
                ]);

                $createdCount++;
            }
        }

        $this->command->info("✅ TeacherSubjectSeeder: Successfully assigned {$createdCount} teacher-subject relationships.");
        $this->command->info("✅ Total teachers: {$teachers->count()}, Total subjects: {$subjects->count()}");
    }
}
