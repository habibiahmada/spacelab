<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuardianClassHistory;
use App\Models\Classroom;
use App\Models\Teacher;

class GuardianClassHistorySeeder extends Seeder
{
    public function run(): void
    {
        $classes = Classroom::all();
        $teachers = Teacher::all();

        if ($classes->isEmpty()) {
            $this->command->warn('⚠️ No classes found. Aborting GuardianClassHistorySeeder.');
            return;
        }

        if ($teachers->isEmpty()) {
            $this->command->warn('⚠️ No teachers found. Aborting GuardianClassHistorySeeder.');
            return;
        }

        $teacherCount = $teachers->count();
        $index = 0;

        // avoid assigning teachers who are head_of_major or program_coordinator
        $roleAssignedTeacherIds = \App\Models\RoleAssignment::pluck('head_of_major_id')
                                ->merge(\App\Models\RoleAssignment::pluck('program_coordinator_id'))
                                ->filter()
                                ->unique()
                                ->toArray();

        foreach ($classes as $class) {
            // choose teacher in round-robin but skip role assigned teachers
            $teacher = null;
            $tries = 0;
            while ($tries < $teacherCount) {
                $candidate = $teachers[$index % $teacherCount];
                $index++;
                $tries++;
                if (! in_array($candidate->id, $roleAssignedTeacherIds)) {
                    $teacher = $candidate;
                    break;
                }
            }

            if (! $teacher) {
                // fallback: just pick random
                $teacher = $teachers->random();
            }

            GuardianClassHistory::updateOrCreate(
                [
                    'teacher_id' => $teacher->id,
                    'class_id' => $class->id,
                ],
                [
                    'started_at' => now()->subMonths(6),
                    'ended_at' => null,
                ]
            );
        }

        $this->command->info('✅ GuardianClassHistorySeeder: assigned guardians to all classes (round-robin).');
    }
}
