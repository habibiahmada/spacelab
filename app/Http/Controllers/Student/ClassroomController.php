<?php

namespace App\Http\Controllers\Student;

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

        $classHistoryQuery = ClassHistory::where('user_id', $user->id);
        
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
            $classmatesQuery = ClassHistory::where('class_id', $classroom->id);
            if ($activeTerm) {
                $classmatesQuery = $classmatesQuery->where('terms_id', $activeTerm->id);
            }
            $students = $classmatesQuery->with('user.student')->get()->map(fn($ch) => $ch->user);

            $guardian = GuardianClassHistory::where('class_id', $classroom->id)
                    ->where(function ($q) {
                        $q->whereNull('ended_at')->orWhere('ended_at', '>=', Carbon::now());
                    })
                    ->orderByDesc('started_at')
                    ->with('teacher.user')
                    ->first();

            $dayOfWeek = Carbon::now()->dayOfWeek; 
            $dayOfWeek = $dayOfWeek === 0 ? 7 : $dayOfWeek;

            $todayEntries = $classroom->timetableEntries()
                ->where('day_of_week', $dayOfWeek)
                ->with(['period', 'teacherSubject.teacher.user', 'teacherSubject.subject', 'roomHistory.room'])
                ->get();

            $currentEntry = $todayEntries->first(fn($e) => $e->isOngoing());
        }

        return view('student.classroom', compact('classroom', 'students', 'guardian', 'todayEntries', 'currentEntry'));
    }
}
