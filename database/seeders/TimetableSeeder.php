<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\{
    TimetableTemplate,
    TimetableEntry,
    Classroom,
    Block,
    Term,
    RoomHistory,
    TeacherSubject,
    Period
};

class TimetableSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('room_history')) {
            $this->command->warn('⚠️ Table room_history does not exist. Run RoomHistorySeeder first.');
            return;
        }

        $term = Term::where('is_active', true)->first();
        $classes = Classroom::all();
        $blocks = Block::all();
        $roomHistory = RoomHistory::all();
        $teacherSubjects = TeacherSubject::all();
        $periods = Period::all();

        if (! $term || $classes->isEmpty()) {
            $this->command->warn('⚠️ Term and classes are required for timetable seeding.');
            return;
        }

        if ($teacherSubjects->isEmpty()) {
            $this->command->warn('⚠️ TeacherSubject data is required. Run TeacherSubjectSeeder first.');
            return;
        }

        if ($periods->isEmpty()) {
            $this->command->warn('⚠️ Period data is required. Create periods before seeding timetable.');
            return;
        }

        if ($roomHistory->isEmpty()) {
            $this->command->warn('⚠️ room_history is empty. Run RoomHistorySeeder first.');
            return;
        }

        // Group room histories by classes_id for preference
        $roomHistoryByClass = $roomHistory->groupBy('classes_id');

        // track used room_history ids per slot key "day:period_id"
        $usedPerSlot = [];
        // track used teacher ids per slot key to avoid double-teaching
        $usedPerSlotTeachers = [];

        foreach ($classes as $class) {
            foreach ($blocks as $block) {
                $template = TimetableTemplate::create([
                    'class_id' => $class->id,
                    'block_id' => $block->id,
                    'version'  => 'v1',
                    'is_active'=> true,
                ]);

                $days = [1,2,3,4,5];
                foreach ($days as $day) {
                    foreach ($periods as $period) {
                        $slotKey = "{$day}:{$period->id}";

                        // candidate histories: prefer matching class, else global pool
                        $candidateHistories = $roomHistoryByClass->get($class->id) ?? $roomHistory;

                        // filter out already used rooms in this slot (track by room_id)
                        $usedRoomIdsInSlot = $usedPerSlot[$slotKey] ?? [];

                        $available = $candidateHistories->filter(function ($rh) use ($usedRoomIdsInSlot) {
                            return ! in_array($rh->room_id, $usedRoomIdsInSlot);
                        });

                        // fallback to global available if none left in class-specific candidate
                        if ($available->isEmpty()) {
                            $available = $roomHistory->filter(function ($rh) use ($usedRoomIdsInSlot) {
                                return ! in_array($rh->room_id, $usedRoomIdsInSlot);
                            });
                        }

                        // final fallback: allow reuse (no choice left)
                        if ($available->isEmpty()) {
                            $selected = $roomHistory->random();
                        } else {
                            $selected = $available->random();
                        }

                        // create entry with chosen room_history_id
                        // pick a teacher subject that hasn't been scheduled within this slot
                        $usedTeachers = $usedPerSlotTeachers[$slotKey] ?? [];
                        $availableTeacherSubjects = $teacherSubjects->filter(function ($t) use ($usedTeachers) {
                            return ! in_array($t->teacher_id, $usedTeachers);
                        });
                        if ($availableTeacherSubjects->isEmpty()) {
                            $ts = $teacherSubjects->random();
                        } else {
                            $ts = $availableTeacherSubjects->random();
                        }
                        TimetableEntry::create([
                            'template_id'         => $template->id,
                            'day_of_week'         => $day,
                            'period_id'           => $period->id,
                            'teacher_subject_id'  => $ts?->id,
                            'room_history_id'     => $selected?->id,
                            'teacher_id'          => $ts?->teacher_id,
                            'room_id'             => $selected?->room_id,
                        ]);

                        // mark used for this slot
                        // mark used room id for this slot
                        $usedPerSlot[$slotKey][] = $selected?->room_id;
                        $usedPerSlotTeachers[$slotKey][] = $ts?->teacher_id;
                    }
                }
            }
        }

        $this->command->info('✅ TimetableSeeder: seeded templates & entries with reduced room conflicts.');
    }
}
