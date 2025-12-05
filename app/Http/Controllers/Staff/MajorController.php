<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    //
    public function index()
    {
        $majors = Major::all();
        return view('staff.major.index', [
            'majors' => $majors,
            'title' => 'Jurusan',
            'description' => 'Halaman jurusan',
        ]);
    }
}
