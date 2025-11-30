<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\GuardianClassHistory;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        $activeTerm = DB::table('terms')->where('is_active', true)->first();

        // Load teacher with relations we will use in the view
        $teacher = $user->teacher?->load([
            'subjects',
            'teacherSubjects.subject',
            'roleAssignments.major',
            'asCoordinatorAssignments.major',
            'guardianClassHistories.class',
        ]);

        // Get the most recent guardian class history (if any)
        $guardian = null;
        if ($teacher) {
            $guardian = GuardianClassHistory::where('teacher_id', $teacher->id)
                ->orderBy('started_at', 'desc')
                ->with('class')
                ->first();
        }

        return view('teacher.profile', [
            'user' => $user,
            'teacher' => $teacher,
            'guardian' => $guardian,
            'term' => $activeTerm,
        ]);
    }
}
