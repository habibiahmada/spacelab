<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ScheduleEntry;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@ilab.sch.id')->first();
        $schedule = ScheduleEntry::first();

        Notification::create([
            'id' => Str::uuid(),
            'user_id' => $user ? $user->id : null,
            'type' => 'info',
            'message' => 'Jadwal pertama semester genap sudah dibuat.',
            'is_read' => false,
            'related_schedule_id' => $schedule ? $schedule->id : null
        ]);
    }
}
