<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TimetableEntry;
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

        $schedulesToday = TimetableEntry::with([
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

        $lessonsCount = $schedulesToday->count();
        $uniqueSubjectsCount = $schedulesToday->pluck('subject.id')->filter()->unique()->count();
        $roomsCount = $schedulesToday->pluck('roomHistory.room.id')->filter()->unique()->count();

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
