<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Models\TimetableEntry;
use App\Models\Classroom;
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

        $activeTerm = DB::table('terms')->where('is_active', true)->first();

        $classHistoryQuery = DB::table('classhistories')
            ->where('user_id', $student->id);

        if ($activeTerm) {
            $classHistoryQuery->where('terms_id', $activeTerm->id);
        }

        $classIds = $classHistoryQuery->pluck('class_id')->unique()->values();

        $studentClassFullName = '-';

        if ($classIds->isEmpty()) {
            Log::warning('⚠️ Tidak ada class history untuk user; tidak menampilkan jadwal.');
            $schedules = collect();
        } else {
            $hasStartTime = Schema::hasColumn('periods', 'start_time');
            $hasStartDate = Schema::hasColumn('periods', 'start_date');

            // Build base query
            $query = TimetableEntry::select('timetable_entries.*')
                ->join('timetable_templates', 'timetable_templates.id', '=', 'timetable_entries.template_id')
                ->join('periods', 'periods.id', '=', 'timetable_entries.period_id')
                ->whereIn('timetable_templates.class_id', $classIds)
                ->where('timetable_entries.day_of_week', $dayIndex);

            // ordering based on available columns
            if ($hasStartTime && $hasStartDate) {
                $query->orderByRaw("COALESCE(to_char(periods.start_time, 'HH24:MI:SS'), to_char(periods.start_date, 'HH24:MI:SS')) ASC");
            } elseif ($hasStartTime) {
                $query->orderBy('periods.start_time', 'asc');
            } elseif ($hasStartDate) {
                $query->orderByRaw("to_char(periods.start_date, 'HH24:MI:SS') ASC");
            } else {
                $query->orderBy('periods.id', 'asc');
            }

            // Eager load roomHistory and its room (nullable-safe). Jangan pakai 'room' langsung.
            $schedules = $query->with([
                    'period',
                    'teacherSubject.subject',
                    'teacherSubject.teacher.user',
                    'roomHistory.room',
                    'template.class.major',
                ])
                ->get();

            $classId = $classIds->first();
            $classroom = Classroom::with('major')->find($classId);
            $studentClassFullName = $classroom?->full_name ?? ($classroom?->name ?? '-');
        }

        return view('student.dashboard', [
            'student'        => $student,
            'schedulesToday' => $schedules,
            'countToday'     => $schedules->count(),
            'today'          => $dayName,
            'currentTime'    => $currentTime,
            'currentDayIndex'=> $dayIndex,
            'studentClassFullName' => $studentClassFullName,
        ]);
    }
}