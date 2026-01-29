<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Subject;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with(['user', 'subjects', 'guardianClassHistories.class', 'roleAssignments', 'asCoordinatorAssignments'])
            ->paginate(15);

        $subjects = Subject::orderBy('name')->get();
        $title = 'Guru';
        $description = 'Halaman Guru';

        return view('admin.pages.teachers', compact('teachers', 'subjects', 'title', 'description'));
    }
}
