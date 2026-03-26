<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\TimetableEntry;
use App\Models\User;
use Illuminate\Database\Seeder;

class AuditLogSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@ilab.sch.id')->first();
        $schedule = TimetableEntry::first();

        AuditLog::create([
            'entity' => 'TimetableEntry',
            'record_id' => $schedule ? $schedule->id : null,
            'action' => 'create',
            'user_id' => $user ? $user->id : null,
            'old_data' => null,
            'new_data' => ['status' => 'confirmed'],
        ]);
    }
}
