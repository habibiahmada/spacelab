<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\TimetableEntry;
use App\Models\Classroom;
use App\Models\Term;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $currentTime = Carbon::now();
        $dayIndex = (int) $currentTime->format('N');
        $dayNames = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => "Jum'at",
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
        $dayName = $dayNames[$dayIndex] ?? $currentTime->isoFormat('dddd');

        $activeTerm = Term::where('is_active', true)->first();

        // Ambil class history user dengan relasi model
        $studentRecord = $student->student;
        $classIds = collect();
        if ($studentRecord) {
            $classHistoryQuery = ClassHistory::where('student_id', $studentRecord->id);
            if ($activeTerm) {
                $classHistoryQuery->where('terms_id', $activeTerm->id);
            }
            $classIds = $classHistoryQuery->pluck('class_id')->unique()->values();
        }

        $studentClassFullName = '-';
        if ($classIds->isEmpty()) {
            Log::warning('⚠️ Tidak ada class history untuk user; tidak menampilkan jadwal.');
            $schedules = collect();
        } else {
            // Ambil jadwal hari ini dengan relasi model
            $schedules = TimetableEntry::whereHas('template', function($q) use ($classIds) {
                    $q->whereIn('class_id', $classIds);
                })
                ->where('day_of_week', $dayIndex)
                ->with([
                    'period',
                    'template.class.major',
                    'teacherSubject.subject',
                    'teacherSubject.teacher.user',
                    'roomHistory.room',
                    'template.class.major',
                ])
                ->orderBy('period_id', 'asc')
                ->get();

            $classId = $classIds->first();
            $classroom = Classroom::with('major')->find($classId);
            $studentClassFullName = $classroom?->full_name ?? ($classroom?->name ?? '-');
        }

        return view('student.dashboard', [
            'student'        => $student,
            'schedulesToday' => $schedules,
            'countToday'     => $schedules->count(),
            'today'          => $dayName,
            'currentTime'    => $currentTime,
            'currentDayIndex'=> $dayIndex,
            'studentClassFullName' => $studentClassFullName,
        ]);
    }
}
