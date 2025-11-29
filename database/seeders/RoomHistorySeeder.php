<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\RoomHistory;
use App\Models\Room;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\Term;
use App\Models\User;

class RoomHistorySeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::all();
        $classes = Classroom::all();
        $terms = Term::all();
        $teachers = Teacher::all();
        $users = User::all();

        if ($rooms->isEmpty() || $classes->isEmpty() || $terms->isEmpty()) {
            $this->command->warn('⚠️ rooms/classes/terms required. Seed them first.');
            return;
        }

        $eventTypes = ['initial', 'relocated', 'lab-setup', 'temporary', 'exam']; // contoh

        // Kita akan membuat kombinasi: untuk setiap room, buat history untuk beberapa class & term
        $created = 0;
        foreach ($rooms as $room) {
            // setiap ruangan buat 2-5 history (acak) agar banyak opsi
            $countPerRoom = rand(2, 5);

            for ($i = 0; $i < $countPerRoom; $i++) {
                $class = $classes->random();
                $term = $terms->random();
                $teacher = $teachers->random()?->id;
                $user = $users->random()?->id;
                $eventType = Arr::random($eventTypes);

                // Pastikan tidak duplicate exact (room+class+term+event_type)
                $exists = RoomHistory::where('room_id', $room->id)
                    ->where('classes_id', $class->id)
                    ->where('terms_id', $term->id)
                    ->where('event_type', $eventType)
                    ->exists();

                if ($exists) {
                    continue;
                }

                RoomHistory::create([
                    'room_id'    => $room->id,
                    'event_type' => $eventType,
                    'classes_id' => $class->id,
                    'terms_id'   => $term->id,
                    'teacher_id' => $teacher,
                    'user_id'    => $user,
                ]);

                $created++;
            }
        }

        $this->command->info("✅ RoomHistorySeeder: created {$created} room_history records.");
    }
}