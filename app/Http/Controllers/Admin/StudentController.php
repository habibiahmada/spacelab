<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Student, Classroom, Major};

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $majors = Major::orderBy('name')->get();
        $classrooms = Classroom::with('major')->get()->sortBy('full_name');
        $title = 'Lihat Siswa';
        $description = 'Semua Siswa';

        return view('admin.pages.students', compact('title', 'description', 'majors', 'classrooms'));
    }
}
