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

        foreach ($classes as $class) {
            $teacher = $teachers[$index % $teacherCount];
            $index++;

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
