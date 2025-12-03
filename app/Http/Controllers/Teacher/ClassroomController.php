<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ClassHistory;
use App\Models\GuardianClassHistory;
use App\Models\Period;
use App\Models\Term;


class ClassroomController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        $activeTerm = Term::where('is_active', true)->first();

        // Determine the classroom via the user's guardian assignment (if any)
        $teacher = $user->teacher;
        $classroom = null;
        $guardian = null;
        if ($teacher) {
            $guardianQuery = GuardianClassHistory::where('teacher_id', $teacher->id)
                    ->where(function ($q) {
                        $q->whereNull('ended_at')->orWhere('ended_at', '>=', Carbon::now());
                    })
                    ->orderByDesc('started_at')
                    ->with(['teacher.user', 'class']);

            $guardian = $guardianQuery->first();
            $classroom = $guardian?->class;
        }

        $students = collect();
        // $guardian already defined above, keep a default if none found.
        $todayEntries = collect();
        $currentEntry = null;

        if ($classroom) {
            $classmatesQuery = ClassHistory::where('class_id', $classroom->id);
            if ($activeTerm) {
                $classmatesQuery = $classmatesQuery->where('terms_id', $activeTerm->id);
            }
            $students = $classmatesQuery->with('student.user')->get()->map(fn($ch) => $ch->student->user);

            // Keep $guardian as the current user's guardian record for the class

            $dayOfWeek = Carbon::now()->dayOfWeek;
            $dayOfWeek = $dayOfWeek === 0 ? 7 : $dayOfWeek;
            $currentTime = Carbon::now();

            $todayEntriesRaw = $classroom->timetableEntries()
                ->where('day_of_week', $dayOfWeek)
                ->with([
                    'period',
                    'teacherSubject.subject',
                    'teacherSubject.teacher.user',
                    'roomHistory.room',
                ])
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
            $existingOrdinals = $todayEntriesRaw->pluck('period.ordinal')->filter()->unique()->sort()->values();

            $shouldShowPeriods = false;
            if ($existingOrdinals->isNotEmpty() && $teachingOrdinals->isNotEmpty()) {
                $shouldShowPeriods = $teachingOrdinals->diff($existingOrdinals)->isEmpty();
            }

            // Hanya tambahkan period entries jika jadwal lengkap
            $periodEntriesForDay = collect();
            if ($shouldShowPeriods) {
                $periodEntriesForDay = $nonTeachingPeriods->map(function($p) use ($dayOfWeek) {
                    return new class($p, $dayOfWeek) {
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
            $todayEntries = $todayEntriesRaw->concat($periodEntriesForDay)->sortBy(function($item) use ($now) {
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

            $currentEntry = $todayEntries->first(fn($e) => method_exists($e, 'isOngoing') ? $e->isOngoing($currentTime) : false);
        }

        return view('teacher.classroom', compact('classroom', 'students', 'guardian', 'todayEntries', 'currentEntry', 'currentTime'));
    }
}
