<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimetableEntry;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $teacher = $user?->teacher;

        if (! $teacher) {
            Log::warning('⚠️ User has no teacher relationship; not showing timetable for teacher.');
            return view('teacher.schedules', [
                'teacher' => null,
                'allSchedules' => collect(),
                'teacherFullName' => $user?->name ?? '-',
                'subjects' => collect(),
                'totalSubjects' => 0,
            ]);
        }

        $activeTerm = DB::table('terms')->where('is_active', true)->first();

        // determine whether periods use start_time or start_date
        $hasStartTime = Schema::hasColumn('periods', 'start_time');
        $hasStartDate = Schema::hasColumn('periods', 'start_date');

        // prepare base query: timetable entries belonging to this teacher
        $query = TimetableEntry::select('timetable_entries.*')
            ->join('teacher_subjects', 'teacher_subjects.id', '=', 'timetable_entries.teacher_subject_id')
            ->join('timetable_templates', 'timetable_templates.id', '=', 'timetable_entries.template_id')
            ->join('periods', 'periods.id', '=', 'timetable_entries.period_id')
            ->where('teacher_subjects.teacher_id', $teacher->id)
            ->whereBetween('timetable_entries.day_of_week', [1, 7]);

        // order by day_of_week then by time or ordinal accordingly
        $query->orderBy('timetable_entries.day_of_week', 'asc');
        if ($hasStartTime && $hasStartDate) {
            $query->orderByRaw("COALESCE(to_char(periods.start_time, 'HH24:MI:SS'), to_char(periods.start_date, 'HH24:MI:SS')) ASC");
        } elseif ($hasStartTime) {
            $query->orderBy('periods.start_time', 'asc');
        } elseif ($hasStartDate) {
            $query->orderByRaw("to_char(periods.start_date, 'HH24:MI:SS') ASC");
        } else {
            $query->orderBy('periods.id', 'asc');
        }

        $allSchedules = $query->with([
                'period',
                'teacherSubject.subject',
                'teacherSubject.teacher.user',
                'roomHistory.room',
                'template.class.major',
            ])
            ->get()
            ->groupBy('day_of_week');

        // ensure we have days 1..7
        $groupedOrdered = collect();
        for ($d = 1; $d <= 7; $d++) {
            $groupedOrdered[$d] = $allSchedules->get($d, collect());
        }

        $allSchedules = $groupedOrdered;

        $teacherFullName = $teacher->user?->name ?? $teacher->name ?? '-';

        // Subjects the teacher teaches (via teacher_subjects pivot)
        $subjects = $teacher->subjects()->orderBy('name')->get();
        $totalSubjects = $subjects->count();

        return view('teacher.schedules', [
            'teacher' => $teacher,
            'teacherFullName' => $teacherFullName,
            'allSchedules' => $allSchedules,
            'subjects' => $subjects,
            'totalSubjects' => $totalSubjects,
        ]);
    }
}
