<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{RoomHistory, Room, Classroom, Term, Teacher};

class RoomHistorySeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::where('type', 'kelas')->get();
        $classes = Classroom::all();
        $terms = Term::all();
        $teachers = Teacher::all();

        if ($rooms->isEmpty() || $classes->isEmpty() || $terms->isEmpty() || $teachers->isEmpty()) {
            $this->command->warn('⚠️ Classroom rooms, classes, terms, and teachers required. Seed them first.');
            return;
        }

        $created = 0;

        // For each classroom room, create history entries that link it to classes
        // This ensures each room can be scheduled for multiple classes
        foreach ($rooms as $room) {
            // Get a subset of classes to assign to this room
            $assignedClasses = $classes->random(min(3, $classes->count()));

            foreach ($assignedClasses as $class) {
                foreach ($terms as $term) {
                    // Pick a random teacher for this room history entry
                    $teacher = $teachers->random();

                    $exists = RoomHistory::where('room_id', $room->id)
                        ->where('classes_id', $class->id)
                        ->where('terms_id', $term->id)
                        ->where('event_type', 'initial')
                        ->exists();

                    if (! $exists) {
                        RoomHistory::create([
                            'room_id'    => $room->id,
                            'event_type' => 'initial',
                            'classes_id' => $class->id,
                            'terms_id'   => $term->id,
                            'teacher_id' => $teacher->id,
                            'user_id'    => $teacher->user_id,
                        ]);
                        $created++;
                    }
                }
            }
        }

        $this->command->info("✅ RoomHistorySeeder: created {$created} room_history records for scheduling.");
    }
}
