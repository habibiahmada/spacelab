<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassHistory;
use App\Models\GuardianClassHistory;
use App\Models\Term;
use App\Models\TimetableEntry;
use Carbon\Carbon;

class ClassroomController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;
        $activeTerm = Term::where('is_active', true)->first();
        $currentTime = Carbon::now();

        // Ambil class history user dengan relasi model
        $classHistory = null;
        if ($student) {
            $classHistoryQuery = ClassHistory::where('student_id', $student->id);
            if ($activeTerm) {
                $classHistoryQuery->where('terms_id', $activeTerm->id);
            }
            $classHistory = $classHistoryQuery->latest('created_at')->first();
        }
        $classroom = $classHistory?->classroom;

        $students = collect();
        $guardian = null;
        $todayEntries = collect();
        $currentEntry = null;

        if ($classroom) {
            // Ambil semua siswa di kelas dengan relasi student.user
            $classmatesQuery = ClassHistory::where('class_id', $classroom->id);
            if ($activeTerm) {
                $classmatesQuery->where('terms_id', $activeTerm->id);
            }
            $students = $classmatesQuery->with('student.user')->get()->map(fn($ch) => $ch->student->user);

            // Ambil wali kelas dengan relasi teacher.user
            $guardian = GuardianClassHistory::where('class_id', $classroom->id)
                ->where(function ($q) {
                    $q->whereNull('ended_at')->orWhere('ended_at', '>=', Carbon::now());
                })
                ->orderByDesc('started_at')
                ->with('teacher.user')
                ->first();

            // Ambil jadwal hari ini dengan relasi model (sama seperti DashboardController)
            $dayOfWeek = (int) $currentTime->format('N');
            $todayEntries = TimetableEntry::whereHas('template', function ($q) use ($classroom) {
                    $q->where('class_id', $classroom->id);
                })
                ->where('day_of_week', $dayOfWeek)
                ->with([
                    'period',
                    'template.class.major',
                    'teacherSubject.subject',
                    'teacherSubject.teacher.user',
                    'roomHistory.room',
                ])
                ->orderBy('period_id', 'asc')
                ->get();

            // Include non-teaching periods as synthetic entries for today and sort by start_time
            $nonTeachingPeriods = \App\Models\Period::where('is_teaching', false)
                ->whereNotNull('start_time')
                ->whereNotNull('end_time')
                ->orderBy('start_time', 'asc')
                ->get();

            $periodEntries = $nonTeachingPeriods->map(function($p) use ($dayOfWeek) {
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

            $now = $currentTime;
            $todayEntries = $todayEntries->concat($periodEntries)->sortBy(function($item) use ($now) {
                $period = $item->period ?? null;
                if (! $period) return PHP_INT_MAX;
                $start = $period->start_time ?? ($period->start_date?->format('H:i:s') ?? null);
                if ($start) {
                    try {
                        $c = Carbon::createFromFormat('H:i:s', $start, $now->getTimezone());
                    } catch (\Exception $e) {
                        try { $c = Carbon::parse($start, $now->getTimezone()); } catch (\Exception $e2) { $c = null; }
                    }
                    if ($c) return $c->timestamp;
                }
                if (isset($period->ordinal)) return (int) $period->ordinal * 1000;
                return PHP_INT_MAX;
            })->values();

            $currentEntry = $todayEntries->first(fn($e) => method_exists($e, 'isOngoing') ? $e->isOngoing($currentTime) : false);
        }

        return view('student.classroom', compact('classroom', 'students', 'guardian', 'todayEntries', 'currentEntry', 'currentTime'));
    }
}
