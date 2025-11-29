<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuardianClassHistory;
use App\Models\ClassRoom;
use App\Models\User;

class GuardianClassHistorySeeder extends Seeder
{
    public function run(): void
    {
        $class = ClassRoom::first();
        $teacher = User::whereHas('role', fn($q) => $q->where('name','Guru'))->first();

        if (!$class || !$teacher) {
            $this->command->warn('⚠️ Missing teacher or class for GuardianClassHistorySeeder.');
            return;
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

        $this->command->info('✅ GuardianClassHistorySeeder: created sample guardian assignment.');
    }
}
