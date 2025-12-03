<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimetableEntry;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // prepare base query: timetable entries belonging to this teacher
        $query = TimetableEntry::whereHas('teacherSubject', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->whereBetween('day_of_week', [1, 7])
            ->orderBy('day_of_week', 'asc')
            ->orderBy('period_id', 'asc');

        $allSchedules = $query->with([
                'period',
                'template.class.major',
                'teacherSubject.subject',
                'teacherSubject.teacher.user',
                'roomHistory.room',
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
