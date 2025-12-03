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

            // Ambil jadwal hari ini dengan relasi model (sama seperti DashboardController)
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

            $currentEntry = $todayEntries->first(fn($e) => method_exists($e, 'isOngoing') ? $e->isOngoing($currentTime) : false);
        }

        return view('student.classroom', compact('classroom', 'students', 'guardian', 'todayEntries', 'currentEntry', 'currentTime'));
    }
}
