<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuardianClassHistory;
use App\Models\Classroom;
use App\Models\RoleAssignment;
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

        $roleAssignedTeacherIds = RoleAssignment::pluck('head_of_major_id')
                    ->merge(RoleAssignment::pluck('program_coordinator_id'))
                                ->filter()
                                ->unique()
                                ->toArray();
        // track already assigned guardians to ensure a teacher isn't guardian for multiple classes at the same time
        $assignedGuardianTeacherIds = [];

        foreach ($classes as $class) {
            // choose teacher in round-robin but skip role assigned teachers and already assigned guardian teachers
            $teacher = null;
            $tries = 0;
            while ($tries < $teacherCount) {
                $candidate = $teachers[$index % $teacherCount];
                $index++;
                $tries++;
                if (! in_array($candidate->id, $roleAssignedTeacherIds) && ! in_array($candidate->id, $assignedGuardianTeacherIds)) {
                    $teacher = $candidate;
                    break;
                }
            }

            if (! $teacher) {
                // fallback: choose any unassigned teacher that is not roleAssigned
                $available = $teachers->filter(function ($t) use ($roleAssignedTeacherIds, $assignedGuardianTeacherIds) {
                    return ! in_array($t->id, $roleAssignedTeacherIds) && ! in_array($t->id, $assignedGuardianTeacherIds);
                });
                if ($available->isNotEmpty()) {
                    $teacher = $available->random();
                }
            }

            if (! $teacher) {
                // no available teacher to become guardian without violating constraint: skip assignment
                continue;
            }

            try {
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
            } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                // Unique constraint violated while seeding — skip and continue
                continue;
            }

            // mark teacher as assigned as guardian so we won't assign them again
            $assignedGuardianTeacherIds[] = $teacher->id;
        }

        $this->command->info('✅ GuardianClassHistorySeeder: assigned guardians to all classes (round-robin).');
    }
}
