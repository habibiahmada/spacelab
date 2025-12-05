<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ClassHistory;
use App\Models\GuardianClassHistory;

class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        $activeTerm = DB::table('terms')->where('is_active', true)->first();

        // Get the most recent class history for the active term (if any)
        $classHistory = null;
        if ($student) {
            $classHistoryQuery = ClassHistory::where('student_id', $student->id);
            if ($activeTerm) {
                $classHistoryQuery->where('terms_id', $activeTerm->id);
            }
            $classHistory = $classHistoryQuery->with(['classroom.major', 'block'])->orderBy('created_at', 'desc')->first();
        }

        $classroom = $classHistory?->classroom;

        // Find the guardian teacher for the class (if available)
        $guardian = null;
        if ($classroom) {
            $guardian = GuardianClassHistory::where('class_id', $classroom->id)
                ->orderBy('started_at', 'desc')
                ->with('teacher.user')
                ->first();
        }

        return view('student.profile', [
            'user' => $user,
            'student' => $user->student,
            'classHistory' => $classHistory,
            'classroom' => $classroom,
            'guardian' => $guardian,
            'term' => $activeTerm,
            'title' => 'Profil',
            'description' => 'Halaman profil',
        ]);
    }
}
