<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Teacher, Student, Room, ClassRoom, ScheduleEntry, AuditLog};

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'teachers' => Teacher::count(),
            'students' => Student::count(),
            'classes' => ClassRoom::count(),
            'rooms' => Room::count(),
            // 'schedules_today' => ScheduleEntry::whereDate('start_at', now())->count(),
            // 'todaySchedules' => ScheduleEntry::with(['room', 'class', 'teacher', 'subject'])
                // ->whereDate('start_at', now())->get(),
            'recentLogs' => AuditLog::with('user')->latest()->take(5)->get(),
            'title' => 'Admin Panel',
            'description' => 'Halaman utama'
        ]);
    }
}
