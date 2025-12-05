<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    //
    public function index()
    {
        return view('staff.teacher.index', [
            'title' => 'Guru',
            'description' => 'Halaman guru',
        ]);
    }
}
