<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\TimetableEntry;
use App\Models\Classroom;
use App\Models\Period;
use App\Models\Term;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $currentTime = Carbon::now();
        $dayIndex = (int) $currentTime->format('N');
        $dayNames = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => "Jum'at",
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
        $dayName = $dayNames[$dayIndex] ?? $currentTime->isoFormat('dddd');

        $activeTerm = Term::where('is_active', true)->first();

        // Ambil class history user dengan relasi model
        $studentRecord = $student->student;
        $classIds = collect();
        if ($studentRecord) {
            $classHistoryQuery = ClassHistory::where('student_id', $studentRecord->id);
            if ($activeTerm) {
                $classHistoryQuery->where('terms_id', $activeTerm->id);
            }
            $classIds = $classHistoryQuery->pluck('class_id')->unique()->values();
        }

        $studentClassFullName = '-';
        if ($classIds->isEmpty()) {
            Log::warning('⚠️ Tidak ada class history untuk user; tidak menampilkan jadwal.');
            $schedules = collect();
        } else {
            // Ambil jadwal hari ini dengan relasi model
            $schedules = TimetableEntry::whereHas('template', function($q) use ($classIds) {
                    $q->whereIn('class_id', $classIds);
                })
                ->where('day_of_week', $dayIndex)
                ->with([
                    'period',
                    'template.class.major',
                    'teacherSubject.subject',
                    'teacherSubject.teacher.user',
                    'roomHistory.room',
                    'template.class.major',
                ])
                ->orderBy('period_id', 'asc')
                ->get();

            $nonTeachingPeriods = Period::where('is_teaching', false)
                ->whereNotNull('start_time')
                ->whereNotNull('end_time')
                ->orderBy('start_time', 'asc')
                ->get();

            $periodEntries = $nonTeachingPeriods->map(function($p) use ($dayIndex) {
                return new class($p, $dayIndex) {
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

            // Gabungkan dan urutkan berdasarkan waktu mulai yang tersedia (start_time atau start_date), lalu end_time
            $merged = $schedules->concat($periodEntries);

            $schedules = $merged->sortBy(function($item) use ($currentTime) {
                $period = $item->period ?? null;
                if (! $period) return PHP_INT_MAX;

                $start = $period->start_time ?? ($period->start_date?->format('H:i:s') ?? null);
                $end = $period->end_time ?? ($period->end_date?->format('H:i:s') ?? null);

                // Prefer start time; convert to seconds-since-midnight for stable numeric sort
                if ($start) {
                    try {
                        $c = \Carbon\Carbon::createFromFormat('H:i:s', $start, $currentTime->getTimezone());
                    } catch (\Exception $e) {
                        try {
                            $c = \Carbon\Carbon::parse($start, $currentTime->getTimezone());
                        } catch (\Exception $e2) {
                            $c = null;
                        }
                    }
                    if ($c) {
                        return $c->timestamp;
                    }
                }

                // Fallback to ordinal if present (ensures consistent ordering)
                if (isset($period->ordinal)) {
                    return (int) $period->ordinal * 1000;
                }

                return PHP_INT_MAX;
            })->values();

            $classId = $classIds->first();
            $classroom = Classroom::with('major')->find($classId);
            $studentClassFullName = $classroom?->full_name ?? ($classroom?->name ?? '-');
        }

        return view('student.dashboard', [
            'student'        => $student,
            'schedulesToday' => $schedules,
            'countToday'     => $schedules->count() - $periodEntries->count(),
            'today'          => $dayName,
            'currentTime'    => $currentTime,
            'currentDayIndex'=> $dayIndex,
            'studentClassFullName' => $studentClassFullName,
        ]);
    }
}
