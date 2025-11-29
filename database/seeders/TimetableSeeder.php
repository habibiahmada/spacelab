<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{TimetableTemplate, TimetableEntry, ClassRoom, Block, Term, Teacher, Subject, Room};
use Illuminate\Support\Str;

class TimetableSeeder extends Seeder
{
    public function run(): void
    {
        $term = Term::where('is_active', true)->first();
        $classes = ClassRoom::all();
        $blocks = Block::all();
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $rooms = Room::whereIn('type', ['kelas', 'lab', 'aula'])->get();

        if (! $term || $classes->isEmpty()) {
            $this->command->warn('⚠️ Term and classes are required for timetable seeding.');
            return;
        }

        foreach ($classes as $class) {
            // create a simple template per class (one per block if present)
            foreach ($blocks as $block) {
                $template = TimetableTemplate::create([
                    'class_id' => $class->id,
                    'block_id' => $block->id,
                    'version' => 'v1',
                    'is_active' => true,
                ]);

                // create simplified timetable entries: 5 days x 3 periods
                $periods = \App\Models\Period::all();
                $days = [1,2,3,4,5];
                foreach ($days as $day) {
                    foreach ($periods as $period) {
                        TimetableEntry::create([
                            'template_id' => $template->id,
                            'day_of_week' => $day,
                            'period_id' => $period->id,
                            'subject_id' => $subjects->random()?->id,
                            'teacher_id' => $teachers->random()?->id,
                            'room_id' => $rooms->random()?->id,
                        ]);
                    }
                }
            }
        }

        $this->command->info('✅ TimetableSeeder: timetable templates & entries seeded.');
    }
}
