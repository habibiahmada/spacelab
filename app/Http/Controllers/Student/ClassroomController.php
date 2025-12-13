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

// Ambil jadwal hari ini
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

    // ===== CEK KELENGKAPAN ORDINAL =====

    $teachingPeriods = \App\Models\Period::where('is_teaching', true)
        ->whereNotNull('ordinal')
        ->orderBy('ordinal', 'asc')
        ->get();

    $teachingOrdinals = $teachingPeriods->pluck('ordinal')->sort()->values();

    $existingOrdinals = $todayEntries
        ->pluck('period.ordinal')
        ->filter()
        ->unique()
        ->sort()
        ->values();

    $isComplete = false;

    if ($existingOrdinals->isNotEmpty() && $teachingOrdinals->isNotEmpty()) {
        $isComplete = $teachingOrdinals->diff($existingOrdinals)->isEmpty();
    }

    // Kalau tidak lengkap → libur
    if (! $isComplete) {
        $todayEntries = collect();
        $currentEntry = null;
    } else {

        // Non-teaching period hanya kalau lengkap
        $nonTeachingPeriods = \App\Models\Period::where('is_teaching', false)
            ->whereNotNull('start_time')
            ->whereNotNull('end_time')
            ->orderBy('ordinal', 'asc')
            ->get();

        $periodEntries = $nonTeachingPeriods->map(function ($p) use ($dayOfWeek) {
            return new class($p, $dayOfWeek) {
                public $period;
                public $template;
                public $teacherSubject;
                public $teacher;
                public $roomHistory;
                public $is_period_only = true;
                public $day_of_week;

                public function __construct($period, $day)
                {
                    $this->period = $period;
                    $this->day_of_week = $day;
                }

                public function isOngoing($now = null)
                {
                    return $this->period?->isOngoing($now);
                }

                public function isPast($now = null)
                {
                    return $this->period?->isPast($now);
                }
            };
        });

        $now = $currentTime;

        $todayEntries = $todayEntries
            ->concat($periodEntries)
            ->sortBy(function ($item) use ($now) {
                if (! $item->period) return PHP_INT_MAX;

                if ($item->period->start_time) {
                    return Carbon::parse($item->period->start_time)->timestamp;
                }

                return $item->period->ordinal
                    ? $item->period->ordinal * 1000
                    : PHP_INT_MAX;
            })
            ->values();

        $currentEntry = $todayEntries->first(
            fn ($e) => method_exists($e, 'isOngoing') && $e->isOngoing($currentTime)
        );
    }
        }

        return view('student.classroom', [
            'classroom' => $classroom,
            'students' => $students,
            'guardian' => $guardian,
            'todayEntries' => $todayEntries,
            'currentEntry' => $currentEntry,
            'currentTime' => $currentTime,
            'title' => 'Kelas',
            'description' => 'Halaman kelas',
        ]);
    }
}
