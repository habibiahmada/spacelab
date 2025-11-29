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
        $student = Auth::user();

        $activeTerm = DB::table('terms')->where('is_active', true)->first();

        // Ambil class history user
        $classHistoryQuery = DB::table('classhistories')
            ->where('user_id', $student->id);

        if ($activeTerm) {
            $classHistoryQuery->where('terms_id', $activeTerm->id);
        }

        $classIds = $classHistoryQuery->pluck('class_id')->unique()->values();

        if ($classIds->isEmpty()) {
            Log::warning('⚠️ Tidak ada class history untuk user; tidak menampilkan jadwal.');
            return view('student.schedules', [
                'student' => $student,
                'allSchedules' => collect(),
                'studentClassFullName' => '-'
            ]);
        }

        // Cek kolom period
        $hasStartTime = Schema::hasColumn('periods', 'start_time');
        $hasStartDate = Schema::hasColumn('periods', 'start_date');

        // Query utama jadwal untuk semua hari (1..7)
        $query = TimetableEntry::select('timetable_entries.*')
            ->join('timetable_templates', 'timetable_templates.id', '=', 'timetable_entries.template_id')
            ->join('periods', 'periods.id', '=', 'timetable_entries.period_id')
            ->whereIn('timetable_templates.class_id', $classIds)
            ->whereBetween('timetable_entries.day_of_week', [1, 7]);


        // Order berdasarkan hari (Senin..Minggu) lalu berdasarkan waktu/nomor periode
        $query->orderBy('timetable_entries.day_of_week', 'asc');
        // Order berdasarkan kolom yang tersedia
        if ($hasStartTime && $hasStartDate) {
            $query->orderByRaw("COALESCE(to_char(periods.start_time, 'HH24:MI:SS'), to_char(periods.start_date, 'HH24:MI:SS')) ASC");
        } elseif ($hasStartTime) {
            $query->orderBy('periods.start_time', 'asc');
        } elseif ($hasStartDate) {
            $query->orderByRaw("to_char(periods.start_date, 'HH24:MI:SS') ASC");
        } else {
            $query->orderBy('periods.id', 'asc');
        }

        $allSchedules = $query->with([
                'period',
                'teacherSubject.subject',
                'teacherSubject.teacher.user',
                'roomHistory.room',
                'template.class.major',
            ])
            ->get()
            ->groupBy('day_of_week'); // Biar enak ditampilkan per hari

        // Pastikan setiap hari 1..7 disediakan, meskipun kosong
        $groupedOrdered = collect();
        for ($d = 1; $d <= 7; $d++) {
            $groupedOrdered[$d] = $allSchedules->get($d, collect());
        }
        $allSchedules = $groupedOrdered;


        // Nama kelas siswa
        $classId = $classIds->first();
        $classroom = Classroom::with('major')->find($classId);
        $studentClassFullName = $classroom?->full_name ?? ($classroom?->name ?? '-');

        return view('student.schedules', [
            'student'              => $student,
            'allSchedules'         => $allSchedules,   // Semua jadwal Senin-Jumat
            'studentClassFullName' => $studentClassFullName,
        ]);
    }

}
