<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    //
    public function index()
    {
        return view('staff.classroom.index', [
            'title' => 'Kelas',
            'description' => 'Halaman kelas',
        ]);
    }
}
