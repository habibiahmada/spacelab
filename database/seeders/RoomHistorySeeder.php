<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Room;
use App\Models\RoomHistory;
use App\Models\Teacher;
use App\Models\Term;
use Illuminate\Database\Seeder;

class RoomHistorySeeder extends Seeder
{
    public function run(): void
    {
        // tidak hanya ruangan dengan tipe kelas tapi juga lab, dll (kecuali ruang serbaguna)
        $rooms = Room::where('type', 'kelas')->orWhere('type', 'lab')->where('name', '!=', 'Ruang Serbaguna')->get();
        $classes = Classroom::all();
        $terms = Term::all();
        $teachers = Teacher::all();

        if ($rooms->isEmpty() || $classes->isEmpty() || $terms->isEmpty() || $teachers->isEmpty()) {
            $this->command->warn('⚠️ Classroom rooms, classes, terms, and teachers required. Seed them first.');

            return;
        }

        $created = 0;

        // Ensure each class gets ONE unique room to prevent scheduling collisions.
        // If there are more classes than rooms, wrap around (though this generally shouldn't happen in a proper setup).
        $availableRooms = collect($rooms->all())->shuffle();

        foreach ($classes as $index => $class) {
            $room = $availableRooms->get($index % $availableRooms->count());

            foreach ($terms as $term) {
                $teacher = $teachers->random();

                $exists = RoomHistory::where('room_id', $room->id)
                    ->where('classes_id', $class->id)
                    ->where('terms_id', $term->id)
                    ->where('event_type', 'initial')
                    ->exists();

                if (! $exists) {
                    RoomHistory::create([
                        'room_id' => $room->id,
                        'event_type' => 'initial',
                        'classes_id' => $class->id,
                        'terms_id' => $term->id,
                        'teacher_id' => $teacher->id,
                        'user_id' => $teacher->user_id,
                        'start_date' => $term->start_date ?? now(),
                        'end_date' => $term->end_date ?? now()->addMonths(6),
                    ]);
                    $created++;
                }
            }
        }

        $this->command->info("✅ RoomHistorySeeder: created {$created} room_history records for scheduling.");
    }
}
