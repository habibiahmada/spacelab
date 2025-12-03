<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TimetableEntry;
use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show teacher dashboard with schedules for the current day.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        // eager load user's teacher relationship and the teacher's user to avoid N+1 when rendering
        $user->loadMissing('teacher.user');
        $teacher = $user->teacher ?? null;

        // If the authenticated user is not a teacher yet, show the view with empty data
        if (! $teacher) {
            return view('teacher.dashboard', [
                'teacher' => null,
                'schedulesToday' => collect(),
                'currentTime' => Carbon::now(),
                'currentDayIndex' => (int) Carbon::now()->format('N'),
                'lessonsCount' => 0,
                'roomsCount' => 0,
            ]);
        }

        $currentTime = Carbon::now();
        $currentDayIndex = (int) $currentTime->format('N');

        // Ambil jadwal kelas untuk hari ini
        $schedulesTodayRaw = TimetableEntry::with([
            'period',
            'template.class.major',
            'teacherSubject.subject',
            'teacherSubject.teacher.user',
            'roomHistory.room.building',
        ])
            ->where('day_of_week', $currentDayIndex)
            ->whereHas('teacherSubject', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->orderBy('period_id', 'asc')
            ->get();

        // Ambil semua period yang is_teaching = false
        $nonTeachingPeriods = Period::where('is_teaching', false)
            ->whereNotNull('start_time')
            ->whereNotNull('end_time')
            ->orderBy('ordinal', 'asc')
            ->get();

        // Ambil semua period yang is_teaching = true untuk validasi kelengkapan
        $teachingPeriods = Period::where('is_teaching', true)
            ->whereNotNull('ordinal')
            ->orderBy('ordinal', 'asc')
            ->get();

        $teachingOrdinals = $teachingPeriods->pluck('ordinal')->sort()->values();

        // Cek kelengkapan ordinal
        $existingOrdinals = $schedulesTodayRaw->pluck('period.ordinal')->filter()->unique()->sort()->values();

        $shouldShowPeriods = false;
        if ($existingOrdinals->isNotEmpty() && $teachingOrdinals->isNotEmpty()) {
            $shouldShowPeriods = $teachingOrdinals->diff($existingOrdinals)->isEmpty();
        }

        // Hanya tambahkan period entries jika jadwal lengkap
        $periodEntriesForDay = collect();
        if ($shouldShowPeriods) {
            $periodEntriesForDay = $nonTeachingPeriods->map(function($p) use ($currentDayIndex) {
                return new class($p, $currentDayIndex) {
                    public $period;
                    public $template;
                    public $teacherSubject;
                    public $teacher;
                    public $roomHistory;
                    public $is_period_only;
                    public $day_of_week;

                    public function __construct($period, $day)
                    {
                        $this->period = $period;
                        $this->template = null;
                        $this->teacherSubject = null;
                        $this->teacher = null;
                        $this->roomHistory = null;
                        $this->is_period_only = true;
                        $this->day_of_week = $day;
                    }

                    public function isOngoing($now = null)
                    {
                        return $this->period ? $this->period->isOngoing($now) : false;
                    }

                    public function isPast($now = null)
                    {
                        return $this->period ? $this->period->isPast($now) : false;
                    }
                };
            });
        }

        // Merge dan sort by start_time
        $now = $currentTime;
        $schedulesToday = $schedulesTodayRaw->concat($periodEntriesForDay)->sortBy(function($item) use ($now) {
            $period = $item->period ?? null;
            if (! $period) return PHP_INT_MAX;

            $start = $period->start_time ?? ($period->start_date?->format('H:i:s') ?? null);
            if ($start) {
                try {
                    $c = Carbon::createFromFormat('H:i:s', $start, $now->getTimezone());
                } catch (\Exception $e) {
                    try {
                        $c = Carbon::parse($start, $now->getTimezone());
                    } catch (\Exception $e2) {
                        $c = null;
                    }
                }
                if ($c) return $c->timestamp;
            }

            if (isset($period->ordinal)) return (int) $period->ordinal * 1000;
            return PHP_INT_MAX;
        })->values();

        $lessonsCount = $schedulesTodayRaw->count();
        $uniqueSubjectsCount = $schedulesTodayRaw->pluck('teacherSubject.subject.id')->filter()->unique()->count();
        $roomsCount = $schedulesTodayRaw->pluck('roomHistory.room.id')->filter()->unique()->count();

        return view('teacher.dashboard', compact(
            'teacher',
            'schedulesToday',
            'currentTime',
            'currentDayIndex',
            'lessonsCount',
            'roomsCount',
            'uniqueSubjectsCount'
        ));
    }
}
