<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Major;
use App\Models\Teacher;
use App\Models\GuardianClassHistory;
use App\Models\Term;
use App\Models\Block;
use App\Models\Student;
use App\Models\ClassHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $majors = Major::with(['classes' => function ($query) {
            $query->orderBy('level', 'asc')
                ->orderBy('rombel', 'asc');
        }])->get();

        return view('staff.classroom.index', [
            'title' => 'Kelas',
            'description' => 'Halaman kelas',
            'majors' => $majors,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'major_id' => 'required|exists:majors,id',
            'level' => 'required|in:10,11,12',
            'rombel' => 'required|in:1,2,3,4,5',
        ]);

        // Check if classroom already exists
        $exists = Classroom::where('major_id', $validated['major_id'])
            ->where('level', $validated['level'])
            ->where('rombel', $validated['rombel'])
            ->exists();

        if ($exists) {
            return redirect()->route('staff.classrooms.index')
                ->with('error', 'Kelas sudah ada untuk jurusan, level, dan rombel ini.');
        }

        Classroom::create($validated);

        return redirect()->route('staff.classrooms.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function showJson($id)
    {
        $classroom = Classroom::with('major')->findOrFail($id);
        return response()->json($classroom);
    }

    public function show($id)
    {
        $classroom = Classroom::with('major')->findOrFail($id);
        $activeTerm = Term::where('is_active', true)->first();

        // Get current guardian
        $guardian = GuardianClassHistory::where('class_id', $classroom->id)
            ->where(function ($q) {
                $q->whereNull('ended_at')->orWhere('ended_at', '>=', Carbon::now());
            })
            ->orderByDesc('started_at')
            ->with('teacher.user')
            ->first();

        // Get students in this class for the active term
        $students = collect();
        if ($activeTerm) {
            $students = ClassHistory::where('class_id', $classroom->id)
                ->where('terms_id', $activeTerm->id)
                ->with('student.user')
                ->get()
                ->map(function ($history) {
                    return $history->student;
                })
                ->sortBy(function ($student) {
                    return $student->user->name;
                })
                ->values();
        }

        $teachers = Teacher::with('user')->get();

        $availableStudents = collect();
        if ($activeTerm) {
            $assignedStudentIds = ClassHistory::where('terms_id', $activeTerm->id)
                ->pluck('student_id');

            $availableStudents = Student::with('user')
                ->whereNotIn('id', $assignedStudentIds)
                ->get();
        }

        return view('staff.classroom.show', [
            'title' => 'Detail Kelas',
            'description' => 'Detail informasi kelas',
            'classroom' => $classroom,
            'guardian' => $guardian,
            'students' => $students,
            'teachers' => $teachers,
            'availableStudents' => $availableStudents,
        ]);
    }

    public function updateGuardian(Request $request, $id)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $classroom = Classroom::findOrFail($id);
        $newTeacherId = $request->teacher_id;

        // End current guardian if exists
        $currentGuardian = GuardianClassHistory::where('class_id', $classroom->id)
            ->where(function ($q) {
                $q->whereNull('ended_at')->orWhere('ended_at', '>=', Carbon::now());
            })
            ->first();

        if ($currentGuardian) {
            if ($currentGuardian->teacher_id == $newTeacherId) {
                return back()->with('info', 'Guru ini sudah menjadi wali kelas ini.');
            }
            $currentGuardian->update(['ended_at' => Carbon::now()]);
        }

        try {
            GuardianClassHistory::create([
                'class_id' => $classroom->id,
                'teacher_id' => $newTeacherId,
                'started_at' => Carbon::now(),
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Wali kelas berhasil diperbarui.');
    }

    public function storeStudent(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $classroom = Classroom::findOrFail($id);
        $activeTerm = Term::where('is_active', true)->firstOrFail();

        // Find current or latest block in the active term
        $activeBlock = Block::where('terms_id', $activeTerm->id)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->first();

        // Fallback: if no current block (e.g. holiday or between blocks), use the latest block of the term
        if (!$activeBlock) {
            $activeBlock = Block::where('terms_id', $activeTerm->id)
                ->orderBy('end_date', 'desc')
                ->first();
        }

        if (!$activeBlock) {
            return back()->with('error', 'Tidak ada block yang aktif atau tersedia untuk tahun ajaran ini.');
        }

        // Check if student is already in a class for this term and block (if strictly checking per block)
        // Adjusting check to be per term as requested, but maybe should be per block?
        // For simplicity and error "Violates unique constraint" avoidance, checking per term first is safer for now.
        $exists = ClassHistory::where('student_id', $request->student_id)
            ->where('terms_id', $activeTerm->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Siswa sudah terdaftar di kelas lain pada tahun ajaran ini.');
        }

        ClassHistory::create([
            'class_id' => $classroom->id,
            'student_id' => $request->student_id,
            'terms_id' => $activeTerm->id,
            'block_id' => $activeBlock->id,
        ]);

        return back()->with('success', 'Siswa berhasil ditambahkan ke kelas.');
    }

    public function destroyStudent($id, $studentId)
    {
        $classroom = Classroom::findOrFail($id);
        $activeTerm = Term::where('is_active', true)->firstOrFail();

        $history = ClassHistory::where('class_id', $classroom->id)
            ->where('student_id', $studentId)
            ->where('terms_id', $activeTerm->id)
            ->firstOrFail();

        $history->delete();

        return back()->with('success', 'Siswa berhasil dihapus dari kelas.');
    }

    public function update(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);

        $validated = $request->validate([
            'major_id' => 'required|exists:majors,id',
            'level' => 'required|in:10,11,12',
            'rombel' => 'required|in:1,2,3,4,5',
        ]);

        // Check if classroom already exists (excluding current classroom)
        $exists = Classroom::where('major_id', $validated['major_id'])
            ->where('level', $validated['level'])
            ->where('rombel', $validated['rombel'])
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->route('staff.classrooms.index')
                ->with('error', 'Kelas sudah ada untuk jurusan, level, dan rombel ini.');
        }

        $classroom->update($validated);

        return redirect()->route('staff.classrooms.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();

        return redirect()->route('staff.classrooms.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
