<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    ScheduleEntry,
    Subject,
    Teacher,
    Term,
    Room,
    ClassRoom
};
use Illuminate\Support\Arr;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $term = Term::where('is_active', true)->first();
        $teachers = Teacher::with('user')->get();
        $subjects = Subject::all();
        $rooms = Room::whereIn('type', ['kelas', 'lab'])->get();
        $classes = ClassRoom::all();

        if (! $term || $teachers->isEmpty() || $subjects->isEmpty() || $rooms->isEmpty() || $classes->isEmpty()) {
            $this->command->warn('⚠️ Pastikan Term, Teacher, Subject, Room, dan Class sudah ada.');
            return;
        }

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $startTime = Carbon::createFromTime(6, 30);
        $endTime = Carbon::createFromTime(15, 0);
        $lessonDuration = 90; // menit per pelajaran (1,5 jam)
        $breakTime = 15; // menit antar pelajaran

        $lessonSlots = [];
        $current = clone $startTime;
        while ($current->addMinutes($lessonDuration)->lessThanOrEqualTo($endTime)) {
            $start = $current->copy()->subMinutes($lessonDuration);
            $lessonSlots[] = [
                'start' => $start->format('H:i'),
                'end' => $current->format('H:i'),
            ];
            $current->addMinutes($breakTime);
        }

        $used = []; // untuk mencegah bentrok (guru + ruang)

        foreach ($classes as $class) {
            foreach ($days as $day) {
                foreach ($lessonSlots as $slot) {
                    $teacher = $teachers->random();
                    $subject = $subjects->random();
                    $room = $rooms->random();

                    $key = "{$day}_{$slot['start']}_{$teacher->id}_{$room->id}";
                    if (isset($used[$key])) {
                        continue; // skip kalau bentrok
                    }

                    ScheduleEntry::create([
                        'room_id' => $room->id,
                        'day' => $day,
                        'class_id' => $class->id,
                        'teacher_id' => $teacher->id,
                        'subject_id' => $subject->id,
                        'term_id' => $term->id,
                        'start_at' => "2025-01-13 {$slot['start']}:00",
                        'end_at' => "2025-01-13 {$slot['end']}:00",
                        'recurrence_rule' => 'WEEKLY',
                        'status' => 'confirmed',
                        'note' => "{$subject->name} bersama {$teacher->name}",
                        'created_by' => null,
                    ]);

                    $used[$key] = true;
                }
            }
        }

        $this->command->info('✅ ScheduleSeeder berhasil membuat jadwal otomatis untuk semua kelas dari Senin–Jumat, 06:30–15:00.');
    }
}