<?php

namespace App\Http\Controllers\Staff\Classroom;

use App\Http\Controllers\Controller;
use App\Models\Classroom;

class JsonController extends Controller
{
    /**
     * Return Classroom JSON.
     */
    public function __invoke($id)
    {
        $classroom = Classroom::with('major')->findOrFail($id);
        return response()->json($classroom);
    }
}
