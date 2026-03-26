<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\TimetableEntry;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@ilab.sch.id')->first();
        $schedule = TimetableEntry::first();

        Notification::create([
            'user_id' => $user ? $user->id : null,
            'type' => 'info',
            'message' => 'Jadwal pertama semester genap sudah dibuat.',
            'is_read' => false,
            'related_schedule_id' => $schedule ? $schedule->id : null,
        ]);
    }
}
