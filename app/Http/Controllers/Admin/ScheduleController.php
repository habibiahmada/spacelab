<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ScheduleEntry, Major, ClassRoom, Teacher};

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $majors = Major::orderBy('name')->get();
        $classrooms = ClassRoom::with('major')
            ->get()
            ->sortBy(fn ($c) => "{$c->level}-{$c->major->name}-{$c->rombel}");

        $teachers = Teacher::orderBy('name')->get();

        $query = ScheduleEntry::with(['room', 'classroom', 'teacher', 'subject'])
            ->orderByRaw("
                CASE
                    WHEN day = 'Senin' THEN 1
                    WHEN day = 'Selasa' THEN 2
                    WHEN day = 'Rabu' THEN 3
                    WHEN day = 'Kamis' THEN 4
                    WHEN day = 'Jumat' THEN 5
                    WHEN day = 'Sabtu' THEN 6
                    ELSE 7
                END
            ")
            ->orderBy('start_at', 'asc');

        if ($request->filled('major')) {
            $query->whereHas('classroom', fn($q) => $q->where('major_id', $request->major));
        }

        if ($request->filled('classroom')) {
            $query->where('classroom_id', $request->classroom);
        }

        if ($request->filled('teacher')) {
            $query->where('teacher_id', $request->teacher);
        }

        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        $schedules = $query->paginate(15)->withQueryString();

        return view('admin.pages.schedules', [
            'schedules' => $schedules,
            'title' => 'Lihat Jadwal',
            'description' => 'Semua Jadwal',
            'majors' => $majors,
            'classrooms' => $classrooms,
            'teachers' => $teachers,
        ]);
    }
}
