<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with(['scheduleEntries.subject'])
            ->orderBy('name', 'asc')
            ->paginate(10); // tampilkan 10 guru per halaman
    
        $title = 'Lihat Guru';
        $description = 'Semua Guru';
    
        return view('admin.pages.teachers', compact('teachers', 'title', 'description'));
    }    
}
