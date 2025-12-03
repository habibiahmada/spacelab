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
    Period,
    Room,
    Teacher
};

class TimetableSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('room_history')) {
            $this->command->warn('⚠️ Table room_history does not exist. Run RoomHistorySeeder first.');
            return;
        }

        $term = Term::where('is_active', true)->first() ?? Term::first();
        $templates = TimetableTemplate::where('is_active', true)->get();
        $teacherSubjects = TeacherSubject::all();
        $periods = Period::orderBy('start_time')->get();
        $rooms = Room::where('type', 'kelas')->get();
        $teachers = Teacher::all();

        if ($templates->isEmpty()) {
            $this->command->warn('⚠️ No timetable templates found. Run TimetableTemplateSeeder first.');
            return;
        }

        if ($teacherSubjects->isEmpty()) {
            $this->command->warn('⚠️ TeacherSubject data is required. Run TeacherSubjectSeeder first.');
            return;
        }

        if ($periods->isEmpty()) {
            $this->command->warn('⚠️ Period data is required. Run PeriodSeeder first.');
            return;
        }

        if ($rooms->isEmpty()) {
            $this->command->warn('⚠️ Classroom rooms are required. Run RoomSeeder first.');
            return;
        }

        if ($teachers->isEmpty()) {
            $this->command->warn('⚠️ Teachers are required. Run TeacherSeeder first.');
            return;
        }

        // Filter only teaching periods (skip breaks) but keep full list if you want explicit break entries
        $teachingPeriods = $periods->filter(fn($p) => ($p->is_teaching ?? true));

        if ($teachingPeriods->isEmpty()) {
            $this->command->warn('⚠️ No teaching periods found (check is_teaching flags).');
            return;
        }

        // Prepare room history map
        $roomHistory = RoomHistory::where('terms_id', $term->id)->get();
        $roomHistoryByClass = $roomHistory->keyBy('classes_id');

        $daysOfWeek = [1,2,3,4,5]; // Monday-Friday
        $periodIds = $teachingPeriods->pluck('id')->toArray();

        // Track teacher/room usage per slot to prevent conflicts
        $teacherSchedule = []; // "day:period" => [teacher_ids]
        $roomSchedule = [];    // "day:period" => [room_ids]

        $entriesCreated = 0;
        $entriesFailed = 0;

        // For each template (class + block + version)
        foreach ($templates as $template) {
            $classId = $template->class_id;

            foreach ($daysOfWeek as $day) {
                foreach ($periodIds as $periodId) {
                    $slotKey = "{$day}:{$periodId}";

                    // find a teacherSubject not already teaching at this slot
                    $candidate = $teacherSubjects->first(function($ts) use ($teacherSchedule, $slotKey) {
                        $used = $teacherSchedule[$slotKey] ?? [];
                        return ! in_array($ts->teacher_id, $used);
                    });

                    if (! $candidate) {
                        // no available teacher for this slot
                        $entriesFailed++;
                        continue;
                    }

                    // find room history mapping for this class and term
                    $roomHistEntry = $roomHistoryByClass->get($classId);

                    if ($roomHistEntry === null) {
                        // pick a free classroom for this slot
                        $usedRooms = $roomSchedule[$slotKey] ?? [];
                        $availableRoom = $rooms->first(function($r) use ($usedRooms) {
                            return ! in_array($r->id, $usedRooms);
                        });

                        if (! $availableRoom) {
                            $availableRoom = $rooms->first(); // fallback
                        }

                        $teacherForRoom = $teachers->random();

                        $roomHistEntry = RoomHistory::updateOrCreate(
                            [
                                'room_id' => $availableRoom->id,
                                'classes_id' => $classId,
                                'terms_id' => $term->id,
                                'event_type' => 'initial',
                            ],
                            [
                                'room_id' => $availableRoom->id,
                                'classes_id' => $classId,
                                'terms_id' => $term->id,
                                'event_type' => 'initial',
                                'teacher_id' => $teacherForRoom->id,
                                'user_id' => $teacherForRoom->user_id ?? null,
                            ]
                        );

                        // refresh map
                        $roomHistoryByClass->put($classId, $roomHistEntry);
                    }

                    // ensure chosen room isn't used in slot; if used, try find alternative roomHistory
                    $usedRooms = $roomSchedule[$slotKey] ?? [];
                    if (in_array($roomHistEntry->room_id, $usedRooms)) {
                        $alternatives = RoomHistory::where('classes_id', $classId)->get();
                        $found = $alternatives->first(function($alt) use ($usedRooms) {
                            return ! in_array($alt->room_id, $usedRooms);
                        });

                        if ($found) {
                            $roomHistEntry = $found;
                        } else {
                            // pick another physical room and create new roomHistory if needed
                            $availableRoom = $rooms->first(function($r) use ($usedRooms) {
                                return ! in_array($r->id, $usedRooms);
                            });

                            if (! $availableRoom) {
                                $availableRoom = $rooms->first();
                            }

                            $teacherForRoom = $teachers->random();

                            $roomHistEntry = RoomHistory::updateOrCreate(
                                [
                                    'room_id' => $availableRoom->id,
                                    'classes_id' => $classId,
                                    'terms_id' => $term->id,
                                    'event_type' => 'initial',
                                ],
                                [
                                    'room_id' => $availableRoom->id,
                                    'classes_id' => $classId,
                                    'terms_id' => $term->id,
                                    'event_type' => 'initial',
                                    'teacher_id' => $teacherForRoom->id,
                                    'user_id' => $teacherForRoom->user_id ?? null,
                                ]
                            );

                            // refresh map
                            $roomHistoryByClass->put($classId, $roomHistEntry);
                        }
                    }

                    // Create timetable entry
                    try {
                        TimetableEntry::create([
                            'template_id'         => $template->id,
                            'day_of_week'         => $day,
                            'period_id'           => $periodId,
                            'teacher_subject_id'  => $candidate->id,
                            'room_history_id'     => $roomHistEntry->id,
                            'teacher_id'          => $candidate->teacher_id,
                            'room_id'             => $roomHistEntry->room_id,
                        ]);

                        // mark teacher and room used in this slot
                        $teacherSchedule[$slotKey][] = $candidate->teacher_id;
                        $roomSchedule[$slotKey][]    = $roomHistEntry->room_id;

                        $entriesCreated++;
                    } catch (\Exception $e) {
                        $entriesFailed++;
                        $this->command->warn("Error creating entry for template {$template->id}: {$e->getMessage()}");
                    }
                }
            }
        }

        $this->command->info("✅ TimetableEntrySeeder: Created {$entriesCreated} entries, {$entriesFailed} failed.");
    }
}
