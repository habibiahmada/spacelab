<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermController extends Controller
{
    //
    public function index()
    {
        return view('staff.term.index');
    }
}
