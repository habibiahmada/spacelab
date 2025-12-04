<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Major;
use App\Models\Period;

class ScheduleController extends Controller
{
    public function index()
    {
        // Only fetch basic major information for tabs (lightweight initial load)
        $majors = Major::select('id', 'code', 'name', 'logo')
            ->withCount('classes')
            ->orderBy('code')
            ->get();

        return view('staff.schedules.index', [
            'majors' => $majors,
        ]);
    }

    /**
     * AJAX endpoint to fetch schedules for a specific major
     */
    public function getMajorSchedules($majorId)
    {
        // Fetch non-teaching periods (breaks)
        $nonTeachingPeriods = Period::where('is_teaching', false)
            ->whereNotNull('start_time')
            ->whereNotNull('end_time')
            ->orderBy('start_time')
            ->get();

        // Fetch classes for this major only
        $classes = Classroom::where('major_id', $majorId)
            ->with([
                'timetableTemplates' => function ($query) {
                    $query->where('is_active', true)
                          ->with([
                              'entries.period',
                              'entries.teacherSubject.subject',
                              'entries.teacherSubject.teacher.user',
                              'entries.room',
                          ]);
                }
            ])
            ->orderBy('level')
            ->orderBy('rombel')
            ->get();

        // Process schedules for each class
        $classes->each(function ($class) use ($nonTeachingPeriods) {
            $template = $class->timetableTemplates->first();
            $entries = $template ? $template->entries : collect();
            $groupedEntries = $entries->groupBy('day_of_week');

            $scheduleDays = [];
            for ($i = 1; $i <= 6; $i++) {
                $dayEntries = $groupedEntries->get($i, collect());

                if ($dayEntries->isNotEmpty()) {
                    // Merge with non-teaching periods
                    $merged = $dayEntries->concat($nonTeachingPeriods->map(function ($p) use ($i) {
                        $period = clone $p;
                        $period->day_of_week = $i;
                        $period->is_break = true;
                        return $period;
                    }));

                    // Sort by start time
                    $sorted = $merged->sortBy(function ($item) {
                        if (isset($item->period)) {
                            return $item->period->start_time;
                        }
                        return $item->start_time;
                    })->values();

                    $scheduleDays[$i] = $sorted;
                }
            }
            $class->schedule_days = $scheduleDays;
        });

        return response()->json([
            'success' => true,
            'classes' => $classes,
        ]);
    }
}
