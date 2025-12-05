<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RoleAssignment;
use App\Models\Term;
use App\Models\ClassHistory;
use App\Models\Teacher;
use App\Models\TeacherSubject;

class MajorHeadController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $teacher = $user?->teacher;
        $activeTerm = Term::where('is_active', true)->first();

        $assignment = null;
        $major = null;
        $classes = collect();
        $teachers = collect();
        $majorSubjects = collect();
        $companies = collect();
        $stats = [
            'class_count' => 0,
            'student_count' => 0,
            'room_count' => 0,
        ];
        $teacherCount = 0;
        $subjectCount = 0;

        if ($teacher) {
            $assignmentQuery = RoleAssignment::with(['major', 'head.user', 'programCoordinator.user'])
                ->where('head_of_major_id', $teacher->id);
            if ($activeTerm) {
                $assignmentQuery->where('terms_id', $activeTerm->id);
            }
            $assignment = $assignmentQuery->first();

                if ($assignment && $assignment->major) {
                $major = $assignment->major;

                $classQuery = $major->classes()->withCount(['classHistories as students_count' => function ($q) use ($activeTerm) {
                    if ($activeTerm) {
                        $q->where('terms_id', $activeTerm->id);
                    }
                }]);
                $classes = $classQuery->paginate(10, ['*'], 'classes_page');

                $companies = $major->companyRelations()->with('company')->get();

                $majorSubjects = $major->majorSubjects()->with('subject')->get();

                $subjectIds = $majorSubjects->pluck('subject_id')->all();
                if (!empty($subjectIds)) {
                    $teacherIdsFromSubjects = TeacherSubject::whereIn('subject_id', $subjectIds)->pluck('teacher_id')->unique()->all();
                } else {
                    $teacherIdsFromSubjects = [];
                }

                $teacherIds = $teacherIdsFromSubjects;
                if ($assignment->head) $teacherIds[] = $assignment->head->id;
                if ($assignment->programCoordinator) $teacherIds[] = $assignment->programCoordinator->id;
                $teacherIds = array_values(array_unique($teacherIds));

                $teacherCount = count($teacherIds);

                if (!empty($teacherIds)) {
                    $teachers = Teacher::whereIn('id', $teacherIds)->with('user')->paginate(10, ['*'], 'teachers_page');
                } else {
                    $teachers = collect();
                }

                $stats['class_count'] = $major->classes()->count();
                $stats['room_count'] = $major->classes()->count();
                $classIds = $major->classes()->pluck('id')->all();
                $studentQuery = ClassHistory::whereIn('class_id', $classIds);
                if ($activeTerm) {
                    $studentQuery->where('terms_id', $activeTerm->id);
                }
                $stats['student_count'] = $studentQuery->count();
                $subjectCount = $majorSubjects->count();
            }
        }

        return view('teacher.major.headofmajor', [
            'major' => $major,
            'assignment' => $assignment,
            'classes' => $classes,
            'teachers' => $teachers,
            'stats' => $stats,
            'activeTerm' => $activeTerm,
            'companies' => $companies,
            'majorSubjects' => $majorSubjects,
            'teacherCount' => $teacherCount,
            'subjectCount' => $subjectCount,
            'title' => 'Kepala Jurusan',
            'description' => 'Halaman kepala jurusan',
        ]);
    }
}
