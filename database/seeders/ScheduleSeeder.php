<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ScheduleEntry;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Term;
use App\Models\Room;
use App\Models\ClassRoom;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $room = Room::where('code', 'LAB01')->first();
        $teacher = Teacher::where('name', 'Andi Setiawan, S.Kom')->first();
        $subject = Subject::where('name', 'Pemrograman Web')->first();
        $term = Term::where('name', 'Semester Genap 2025')->first();
        $class = ClassRoom::where('name', '12 RPL 1')->first();

        // Pastikan semua relasi ditemukan sebelum membuat schedule
        if (! $room || ! $teacher || ! $subject || ! $term || ! $class) {
            $missing = collect([
                'room' => $room,
                'teacher' => $teacher,
                'subject' => $subject,
                'term' => $term,
                'class' => $class,
            ])->filter(fn ($value) => ! $value)->keys()->implode(', ');

            $this->command->warn("⚠️  ScheduleSeeder dilewati karena data berikut belum ada: {$missing}");
            return;
        }

        ScheduleEntry::create([
            'room_id' => $room->id,
            'class_id' => $class->id,
            'teacher_id' => $teacher->id,
            'subject_id' => $subject->id,
            'term_id' => $term->id,
            'start_at' => '2025-01-15 08:00:00',
            'end_at' => '2025-01-15 10:00:00',
            'recurrence_rule' => 'WEEKLY',
            'status' => 'confirmed',
            'note' => 'Pertemuan pertama pemrograman web.',
            'created_by' => null,
        ]);
    }
}
