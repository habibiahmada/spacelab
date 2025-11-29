<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomHistory;
use App\Models\Room;
use App\Models\ClassRoom;
use App\Models\Term;
use App\Models\User;

class RoomHistorySeeder extends Seeder
{
    public function run(): void
    {
        $room = Room::first();
        $class = ClassRoom::first();
        $term = Term::first();
        $teacher = \App\Models\Teacher::first();
        $user = User::first();

        if (! $room || ! $class || ! $term) {
            $this->command->warn('⚠️ Missing required records (rooms/classes/terms) for RoomHistorySeeder.');
            return;
        }

        RoomHistory::updateOrCreate(
            ['room_id' => $room->id, 'event_type' => 'initial'],
            [
                'classes_id' => $class->id,
                'terms_id' => $term->id,
                'teacher_id' => $teacher?->id,
                'user_id' => $user?->id,
            ]
        );

        $this->command->info('✅ RoomHistorySeeder: created sample room history.');
    }
}
