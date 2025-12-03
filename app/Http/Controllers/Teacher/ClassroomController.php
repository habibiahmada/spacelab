<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ClassHistory;
use App\Models\GuardianClassHistory;
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

            $todayEntries = $classroom->timetableEntries()
                ->where('day_of_week', $dayOfWeek)
                ->with([
                    'period',
                    'teacherSubject.subject',
                    'teacherSubject.teacher.user',
                    'roomHistory.room',
                ])
                ->orderBy('period_id', 'asc')
                ->get();

            $currentEntry = $todayEntries->first(fn($e) => $e->isOngoing());
        }

        return view('teacher.classroom', compact('classroom', 'students', 'guardian', 'todayEntries', 'currentEntry'));
    }
}
