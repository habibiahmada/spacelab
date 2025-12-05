<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //
    public function index()
    {
        return view('staff.student.index', [
            'title' => 'Siswa',
            'description' => 'Halaman siswa',
        ]);
    }
}
