<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditLog;
use App\Models\User;
use App\Models\ScheduleEntry;

class AuditLogSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@ilab.sch.id')->first();
        $schedule = ScheduleEntry::first();

        AuditLog::create([
            'entity' => 'ScheduleEntry',
            'record_id' => $schedule ? $schedule->id : null,
            'action' => 'create',
            'user_id' => $user ? $user->id : null,
            'old_data' => null,
            'new_data' => json_encode(['status' => 'confirmed'])
        ]);
    }
}
