<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        // Find the active term if available
        $activeTerm = Term::where('is_active', true)->first();

        // Find the student's current class history for the active term or latest
        $classHistoryQuery = $user->classHistory();
        if ($activeTerm) {
            $classHistoryQuery = $classHistoryQuery->where('terms_id', $activeTerm->id);
        }
        $classHistory = $classHistoryQuery->latest('created_at')->first();

        $classroom = $classHistory?->classroom;

        $students = collect();
        $guardian = null;
        $todayEntries = collect();
        $currentEntry = null;

        if ($classroom) {
            // Load classmates from class history (same class and term)
            $classmatesQuery = ClassHistory::where('class_id', $classroom->id);
            if ($activeTerm) {
                $classmatesQuery = $classmatesQuery->where('terms_id', $activeTerm->id);
            }
            $students = $classmatesQuery->with('user.student')->get()->map(fn($ch) => $ch->user);

            // Find the guardian (wali kelas) — latest active guardian for the class
            $guardian = GuardianClassHistory::where('class_id', $classroom->id)
                    ->where(function ($q) {
                        $q->whereNull('ended_at')->orWhere('ended_at', '>=', Carbon::now());
                    })
                    ->orderByDesc('started_at')
                    ->with('teacher.user')
                    ->first();

            // Today timetable entries
            $dayOfWeek = Carbon::now()->dayOfWeek; // Carbon: 0 Sun, 1 Mon
            $dayOfWeek = $dayOfWeek === 0 ? 7 : $dayOfWeek; // convert to 1..7 where 7 is Sunday

            $todayEntries = $classroom->timetableEntries()
                ->where('day_of_week', $dayOfWeek)
                ->with(['period', 'teacherSubject.teacher.user', 'teacherSubject.subject', 'roomHistory.room'])
                ->get();

            $currentEntry = $todayEntries->first(fn($e) => $e->isOngoing());
        }

        return view('student.classroom', compact('classroom', 'students', 'guardian', 'todayEntries', 'currentEntry'));
    }
}
