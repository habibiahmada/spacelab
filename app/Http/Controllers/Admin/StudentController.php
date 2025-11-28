<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Student, ClassRoom};

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $classFilter = $request->input('classroom_id');
    
        $query = Student::with(['user', 'classroom'])
            ->join('users', 'students.user_id', '=', 'users.id')
            ->select('students.*')
            ->orderBy('users.name', 'asc');
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('students.nis', 'like', "%{$search}%")
                  ->orWhere('students.nisn', 'like', "%{$search}%");
            });
        }
    
        if ($classFilter) {
            $query->where('students.classroom_id', $classFilter);
        }
    
        $students = $query->paginate(10)->withQueryString();
        $classrooms = ClassRoom::get();
    
        $title = 'Lihat Siswa';
        $description = 'Semua Siswa';
    
        return view('admin.pages.students', compact('students', 'title', 'description', 'classrooms', 'search', 'classFilter'));
    }
}
