<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    //
    public function index()
    {
        return view('staff.major.index');
    }
}
