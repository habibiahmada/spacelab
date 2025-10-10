<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\{Teacher, Student, Room, ClassRoom, ScheduleEntry, AuditLog, Major};

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'teachers' => Teacher::count(),
            'students' => Student::count(),
            'classes' => ClassRoom::count(),
            'rooms' => Room::count(),
            'schedules_today' => ScheduleEntry::whereDate('start_at', now())->count(),
            'todaySchedules' => ScheduleEntry::with(['room', 'class', 'teacher', 'subject'])
                ->whereDate('start_at', now())->get(),
            'recentLogs' => AuditLog::with('user')->latest()->take(5)->get(),
            'title' => 'Admin Panel',
            'description' => 'Halaman utama'
        ]);
    }

    public function getTeacher()
    {
        // Ambil semua data guru dengan relasi jadwal dan mata pelajaran
        $teachers = Teacher::with(['scheduleEntries.subject'])
            ->orderBy('name', 'asc')
            ->get();

        $title = 'Lihat Guru';
        $description = 'Semua Guru';

        return view('admin.pages.teachers', compact('teachers', 'title', 'description'));
    }

    public function getStudent()
    {
        // Ambil semua siswa beserta relasi user dan kelas
        $students = Student::with(['user', 'classroom'])
            ->join('users', 'students.user_id', '=', 'users.id') // join agar bisa urut berdasarkan nama user
            ->orderBy('users.name', 'asc')
            ->select('students.*') // pastikan hasil tetap model Student
            ->get();

        // Data tambahan untuk view
        $title = 'Lihat Siswa';
        $description = 'Semua Siswa';

        // Kirim data ke view
        return view('admin.pages.students', compact('students', 'title', 'description'));
    }

    public function getClass(Request $request)
    {
        $query = ClassRoom::with(['major', 'homeroomTeacher'])
            ->orderBy('level');
    
        // Fitur pencarian (berdasarkan level, rombel, atau nama jurusan)
        if ($search = $request->input('search')) {
            $query->where('rombel', 'ILIKE', "%{$search}%") // PostgreSQL friendly (case-insensitive)
                  ->orWhere('level', 'ILIKE', "%{$search}%")
                  ->orWhereHas('major', function ($q) use ($search) {
                      $q->where('name', 'ILIKE', "%{$search}%");
                  })
                  ->orWhereHas('homeroomTeacher', function ($q) use ($search) {
                      $q->where('name', 'ILIKE', "%{$search}%");
                  });
        }
    
        // Pagination
        $classes = $query->paginate(10)->withQueryString();
    
        $title = 'Lihat Kelas';
        $description = 'Semua Kelas';
    
        return view('admin.pages.classes', compact('classes', 'title', 'description'));
    }    

    public function getMajor(Request $request)
    {
        $query = Major::with(['headOfMajor', 'programCoordinator'])
            ->orderBy('name');
    
        // Fitur pencarian (berdasarkan nama, kode, deskripsi, atau kepala jurusan)
        if ($search = $request->input('search')) {
            $query->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('code', 'ILIKE', "%{$search}%")
                  ->orWhere('description', 'ILIKE', "%{$search}%")
                  ->orWhereHas('headOfMajor', function ($q) use ($search) {
                      $q->where('name', 'ILIKE', "%{$search}%");
                  })
                  ->orWhereHas('programCoordinator', function ($q) use ($search) {
                      $q->where('name', 'ILIKE', "%{$search}%");
                  });
        }
    
        // Pagination (10 data per halaman)
        $majors = $query->paginate(10)->withQueryString();
    
        $title = 'Lihat Jurusan';
        $description = 'Semua Jurusan';
    
        return view('admin.pages.majors', compact('majors', 'title', 'description'));
    }
    
    public function getRoom(Request $request)
    {
        $query = Room::query();
    
        // Fitur pencarian
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('code', 'ILIKE', "%{$search}%")
                  ->orWhere('building', 'ILIKE', "%{$search}%")
                  ->orWhere('type', 'ILIKE', "%{$search}%");
            });
        }
    
        // Urutkan berdasarkan nama ruangan
        $rooms = $query->orderBy('name', 'asc')
                       ->paginate(10)
                       ->withQueryString();
    
        $title = 'Lihat Ruangan';
        $description = 'Semua Ruangan';
    
        return view('admin.pages.rooms', compact('rooms', 'title', 'description'));
    }    

    public function getSchedule(Request $request)
    {
        // Ambil semua opsi untuk filter dropdown
        $majors = Major::orderBy('name')->get();
        $classrooms = Classroom::with('major')
            ->get()
            ->sortBy(fn ($c) => "{$c->level}-{$c->major->name}-{$c->rombel}");

        $teachers = Teacher::orderBy('name')->get();
    
        // Query dasar jadwal
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
    
        // Terapkan filter jika ada
        if ($request->filled('major')) {
            $query->whereHas('classroom', function ($q) use ($request) {
                $q->where('major_id', $request->major);
            });
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
    
        // Pagination (15 data per halaman)
        $schedules = $query->paginate(15)->withQueryString();
    
        // Title & description
        $title = 'Lihat Jadwal';
        $description = 'Semua Jadwal';
    
        // Kirim semua data ke view
        return view('admin.pages.schedules', compact(
            'schedules',
            'title',
            'description',
            'majors',
            'classrooms',
            'teachers'
        ));
    }    
}
