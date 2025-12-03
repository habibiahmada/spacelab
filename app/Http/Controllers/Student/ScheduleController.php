<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\TimetableEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ScheduleController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;
        $activeTerm = \App\Models\Term::where('is_active', true)->first();

        // Ambil class history user dengan relasi model
        $classIds = collect();
        if ($student) {
            $classHistoryQuery = \App\Models\ClassHistory::where('student_id', $student->id);
            if ($activeTerm) {
                $classHistoryQuery->where('terms_id', $activeTerm->id);
            }
            $classIds = $classHistoryQuery->pluck('class_id')->unique()->values();
        }

        if ($classIds->isEmpty()) {
            Log::warning('⚠️ Tidak ada class history untuk user; tidak menampilkan jadwal.');
            return view('student.schedules', [
                'student' => $user,
                'allSchedules' => collect(),
                'studentClassFullName' => '-'
            ]);
        }

        // Ambil semua jadwal dengan relasi model
        $allSchedulesRaw = \App\Models\TimetableEntry::whereHas('template', function($q) use ($classIds) {
                $q->whereIn('class_id', $classIds);
            })
            ->whereBetween('day_of_week', [1, 7])
            ->with([
                'period',
                'template.class.major',
                'teacherSubject.subject',
                'teacherSubject.teacher.user',
                'roomHistory.room',
            ])
            ->orderBy('day_of_week', 'asc')
            ->orderBy('period_id', 'asc')
            ->get()
            ->groupBy('day_of_week');

        // Pastikan setiap hari 1..7 disediakan, meskipun kosong
        $groupedOrdered = collect();
        for ($d = 1; $d <= 7; $d++) {
            $groupedOrdered[$d] = $allSchedulesRaw->get($d, collect());
        }
        $allSchedules = $groupedOrdered;

        // Nama kelas siswa
        $classId = $classIds->first();
        $classroom = \App\Models\Classroom::with('major')->find($classId);
        $studentClassFullName = $classroom?->full_name ?? ($classroom?->name ?? '-');

        return view('student.schedules', [
            'student'              => $student,
            'allSchedules'         => $allSchedules,
            'studentClassFullName' => $studentClassFullName,
        ]);
    }

}
