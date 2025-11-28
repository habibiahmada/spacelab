<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ScheduleEntry;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        // Ambil jadwal hari ini
        $today = Carbon::now()->locale('id')->dayName;
        $todaySchedules = ScheduleEntry::with(['subject', 'teacher.user', 'room'])
            ->where('day', $today)
            ->where('class_room_id', $student->class_room_id)
            ->orderBy('start_time')
            ->get();

        $countToday = $todaySchedules->count();

        return view('siswa.dashboard', compact('student', 'todaySchedules', 'countToday', 'today'));
    }
}
