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
        $user->loadMissing('teacher.user');
        $teacher = $user->teacher ?? null;

        if (! $teacher) {
            return view('teacher.dashboard', [
                'teacher' => null,
                'schedulesToday' => collect(),
                'currentTime' => Carbon::now(),
                'currentDayIndex' => (int) Carbon::now()->format('N'),
                'lessonsCount' => 0,
                'roomsCount' => 0,
                'uniqueSubjectsCount' => 0,
            ]);
        }

        $currentTime = Carbon::now();
        $currentDayIndex = (int) $currentTime->format('N');

        // Ambil jadwal kelas untuk hari ini (TimetableEntry)
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

        // Ambil semua period yang bukan mengajar (mis. interval/recess) — akan ditampilkan juga
        $nonTeachingPeriods = Period::where('is_teaching', false)
            ->whereNotNull('start_time')
            ->whereNotNull('end_time')
            ->orderBy('ordinal', 'asc')
            ->get();

        // Ambil semua period mengajar untuk validasi (jika mau pakai logika lengkap)
        $teachingPeriods = Period::where('is_teaching', true)
            ->whereNotNull('ordinal')
            ->orderBy('ordinal', 'asc')
            ->get();

        $teachingOrdinals = $teachingPeriods->pluck('ordinal')->sort()->values();

        // Cek existing ordinals — hati-hati bila relation period null
        $existingOrdinals = $schedulesTodayRaw
            ->map(fn($e) => $e->period?->ordinal)
            ->filter()
            ->unique()
            ->sort()
            ->values();

        // Jika mau memaksa tampil hanya saat lengkap, set $requireComplete = true
        // Untuk behavior saat ini (merge selalu), set false.
        $requireComplete = false;

        $shouldShowPeriods = false;
        if (! $requireComplete) {
            // selalu tampilkan non-teaching periods (mis. break, assembly) — aman dan sederhana
            $shouldShowPeriods = $nonTeachingPeriods->isNotEmpty();
        } else {
            // hanya tampilkan bila ordinals pengajaran lengkap
            if ($existingOrdinals->isNotEmpty() && $teachingOrdinals->isNotEmpty()) {
                $shouldShowPeriods = $teachingOrdinals->diff($existingOrdinals)->isEmpty();
            }
        }

        // Buat period-only entries (virtual entries) bila dibutuhkan
        $periodEntriesForDay = collect();
        if ($shouldShowPeriods) {
            $periodEntriesForDay = $nonTeachingPeriods->map(function($p) use ($currentDayIndex) {
                // object sederhana yang mirip TimetableEntry, agar view tidak perlu banyak berubah
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
                        $now = $now ?: Carbon::now();
                        // Jika model Period punya method isOngoing, delegasikan.
                        if (method_exists($this->period, 'isOngoing')) {
                            return $this->period->isOngoing($now);
                        }
                        // fallback: bandingkan waktu start/end
                        try {
                            $start = Carbon::parse($this->period->start_time, $now->getTimezone());
                            $end = Carbon::parse($this->period->end_time, $now->getTimezone());
                            return $now->between($start, $end);
                        } catch (\Throwable $e) {
                            return false;
                        }
                    }

                    public function isPast($now = null)
                    {
                        $now = $now ?: Carbon::now();
                        if (method_exists($this->period, 'isPast')) {
                            return $this->period->isPast($now);
                        }
                        try {
                            $end = Carbon::parse($this->period->end_time, $now->getTimezone());
                            return $now->gt($end);
                        } catch (\Throwable $e) {
                            return false;
                        }
                    }
                };
            })->values();
        }

        // Gabungkan schedulenya dan sort by start time (toleran terhadap format H:i dan H:i:s)
        $now = $currentTime;
        $schedulesToday = $schedulesTodayRaw
            ->concat($periodEntriesForDay)
            ->sortBy(function($item) use ($now) {
                $period = $item->period ?? null;
                if (! $period) return PHP_INT_MAX;

                // start_time bisa format "08:00" atau "08:00:00" atau null
                $startRaw = $period->start_time ?? null;

                if ($startRaw) {
                    // coba beberapa format
                    $formats = ['H:i:s', 'H:i'];
                    foreach ($formats as $fmt) {
                        try {
                            $c = Carbon::createFromFormat($fmt, $startRaw, $now->getTimezone());
                            // jika format tanpa tahun/bulan/hari, set tanggal ke hari ini agar timestamp konsisten
                            if ($c->year === 1970 || $c->year === 1) {
                                $c->setDate($now->year, $now->month, $now->day);
                            }
                            return $c->timestamp;
                        } catch (\Exception $e) {
                            // lanjut ke format berikutnya
                        }
                    }
                    // fallback generic parse
                    try {
                        $c = Carbon::parse($startRaw, $now->getTimezone());
                        return $c->timestamp;
                    } catch (\Exception $e) {
                        // ignore
                    }
                }

                // jika tidak ada start_time, resort by ordinal jika ada
                if (isset($period->ordinal) && $period->ordinal !== null) {
                    return (int) $period->ordinal * 1000;
                }

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
