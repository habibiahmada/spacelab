<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ScheduleEntry;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Term;
use App\Models\Room;
use App\Models\ClassRoom;
use Illuminate\Support\Str;


class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $room = Room::where('code', 'LAB01')->first();
        $teacher = Teacher::where('name', 'Andi Setiawan, S.Kom')->first();
        $subject = Subject::where('name', 'Pemrograman Web')->first();
        $term = Term::where('name', 'Semester Genap 2025')->first();
        $class = ClassRoom::where('name', '12 RPL 1')->first();

        ScheduleEntry::insert([
            [
                'id' => (string) Str::uuid(),
                'room_id' => $room ? $room->id : null,
                'class_id' => $class ? $class->id : null,
                'teacher_id' => $teacher->id,
                'subject_id' => $subject->id,
                'term_id' => $term->id,
                'start_at' => '2025-01-15 08:00:00',
                'end_at' => '2025-01-15 10:00:00',
                'recurrence_rule' => 'WEEKLY',
                'status' => 'confirmed',
                'note' => 'Pertemuan pertama pemrograman web.',
                'created_by' => null
            ]
        ]);
    }
}
