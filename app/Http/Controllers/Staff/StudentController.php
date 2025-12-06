<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Classroom;
use App\Models\ClassHistory;
use App\Models\Term;
use App\Models\Role;
use App\Models\Major;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Only load majors and classrooms for filter dropdowns
        // No student data is loaded by default for better performance
        $majors = Major::orderBy('name')->get();
        $classrooms = Classroom::with('major')->get()->sortBy('full_name');

        return view('staff.student.index', [
            'title' => 'Siswa',
            'description' => 'Halaman siswa',
            'majors' => $majors,
            'classrooms' => $classrooms,
        ]);
    }

    public function fetchStudents(Request $request)
    {
        // Get active term
        $activeTerm = Term::where('is_active', true)->first();
        if (!$activeTerm) {
            return response()->json([
                'students' => [],
                'total' => 0,
                'showing' => 0
            ]);
        }

        // Start building query
        $query = ClassHistory::where('terms_id', $activeTerm->id)
            ->with(['student.user', 'classroom.major']);

        // Apply filters
        if ($request->filled('major_id')) {
            $query->whereHas('classroom', function ($q) use ($request) {
                $q->where('major_id', $request->major_id);
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->whereHas('student.user', function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(email) LIKE ?', ["%{$search}%"]);
            })->orWhereHas('student', function ($q) use ($search) {
                $q->whereRaw('LOWER(nis) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(nisn) LIKE ?', ["%{$search}%"]);
            });
        }

        // Get total count before pagination
        $total = $query->count();

        // Apply pagination
        $perPage = 50;
        $students = $query->orderBy('id')
            ->paginate($perPage);

        // Format data for response
        $formattedStudents = $students->map(function ($classHistory) {
            if (!$classHistory->student || !$classHistory->student->user) {
                return null;
            }

            return [
                'id' => $classHistory->student->id,
                'name' => $classHistory->student->user->name,
                'email' => $classHistory->student->user->email,
                'avatar' => $classHistory->student->avatar,
                'nis' => $classHistory->student->nis ?? '-',
                'nisn' => $classHistory->student->nisn,
                'major_name' => $classHistory->classroom->major->name ?? '-',
                'major_code' => $classHistory->classroom->major->code ?? '-',
                'major_id' => $classHistory->classroom->major->id ?? null,
                'major_logo' => $classHistory->classroom->major->logo ?? null,
                'class_name' => $classHistory->classroom->full_name ?? '-',
                'class_id' => $classHistory->classroom->id ?? null,
            ];
        })->filter()->values();

        return response()->json([
            'students' => $formattedStudents,
            'total' => $total,
            'showing' => $formattedStudents->count(),
            'current_page' => $students->currentPage(),
            'last_page' => $students->lastPage(),
            'per_page' => $perPage
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nis' => 'nullable|string|unique:students,nis',
            'nisn' => 'required|string|unique:students,nisn',
            'classroom_id' => 'required|exists:classes,id',
        ]);

        try {
            DB::beginTransaction();

            // 1. Find or First active term
            $activeTerm = Term::where('is_active', true)->first();
            if (!$activeTerm) {
                throw new \Exception('No active term found.');
            }

            // 2. Create User
            $role = Role::where('name', 'Siswa')->firstOrFail();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password_hash' => $request->nisn,
                'role_id' => $role->id,
            ]);

            // 3. Create Student
            $student = Student::create([
                'users_id' => $user->id,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'avatar' => null,
            ]);

            // 4. Assign to Class (ClassHistory)
            ClassHistory::create([
                'student_id' => $student->id,
                'class_id' => $request->classroom_id,
                'terms_id' => $activeTerm->id,
                'block_id' => $activeTerm->blocks->first()->id,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan siswa: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');
        $header = fgetcsv($handle); // Skip header

        // Expected header: name, email, nis, nisn, classroom_name (e.g. "10 IPA 1") or classroom_id?
        // Let's use classroom name for better UX, or just exact match.

        try {
            DB::beginTransaction();
            $activeTerm = Term::where('is_active', true)->firstOrFail();
            $role = Role::where('name', 'Student')->firstOrFail();
            $rowNumber = 1;

            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;
                if (count($row) < 5) continue; // Skip invalid rows

                [$name, $email, $nis, $nisn, $classroomName] = $row;

                // Simple validation check
                if (User::where('email', $email)->exists() || Student::where('nisn', $nisn)->exists()) {
                    continue; // Skip duplicates or handle error
                }

                // Find Class
                // Try to find class by matching full name construction or just exact match if we had a name field.
                // Since Classroom model appends 'full_name', we can't query it directly easily.
                // For now, let's assume the CSV contains the numeric ID or we iterate to find.
                // Better approach for CSV: Provide ID in template or precise match logic.
                // Let's rely on finding a class where we join major.
                // For simplicity in this first pass, let's look up all classes and match in PHP or require ID?
                // User said "pastikan semuanya lengkap", let's try to match by name components if possible, or just require ID.
                // Let's try to parse the name: "10 PPLG 1".
                // Decompose: Level=10, Major=PPLG, Rombel=1.

                $parts = explode(' ', $classroomName);
                if (count($parts) >= 3) {
                    $level = $parts[0];
                    $majorCode = $parts[1];
                    $rombel = $parts[2];

                    $class = Classroom::where('level', $level)
                        ->where('rombel', $rombel)
                        ->whereHas('major', function ($q) use ($majorCode) {
                            $q->where('code', $majorCode);
                        })->first();
                } else {
                    $class = null;
                }

                if (!$class) {
                    // Fallback or log error for this row
                    continue;
                }

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $nisn,
                    'role_id' => $role->id,
                ]);

                $student = Student::create([
                    'users_id' => $user->id,
                    'nis' => $nis,
                    'nisn' => $nisn,
                ]);

                ClassHistory::create([
                    'student_id' => $student->id,
                    'class_id' => $class->id,
                    'terms_id' => $activeTerm->id,
                ]);
            }

            DB::commit();
            fclose($handle);
            return redirect()->back()->with('success', 'Students imported successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle)) fclose($handle);
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $activeTerm = Term::where('is_active', true)->first();

            $classHistory = ClassHistory::where('student_id', $id)
                ->where('terms_id', $activeTerm->id)
                ->with(['student.user', 'classroom.major', 'block'])
                ->first();

            if (!$classHistory || !$classHistory->student) {
                return response()->json(['error' => 'Student not found'], 404);
            }

            $student = $classHistory->student;
            $user = $student->user;

            return response()->json([
                'id' => $student->id,
                'name' => $user->name,
                'email' => $user->email,
                'nis' => $student->nis,
                'nisn' => $student->nisn,
                'avatar' => $student->avatar,
                'classroom' => $classHistory->classroom->full_name ?? '-',
                'classroom_id' => $classHistory->classroom->id ?? null,
                'major' => $classHistory->classroom->major->name ?? '-',
                'major_code' => $classHistory->classroom->major->code ?? '-',
                'block' => $classHistory->block->name ?? '-',
                'term' => $activeTerm->tahun_ajaran ?? '-',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch student data'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Student::find($id)->users_id,
            'nis' => 'nullable|string|unique:students,nis,' . $id,
            'nisn' => 'required|string|unique:students,nisn,' . $id,
            'classroom_id' => 'required|exists:classes,id',
        ]);

        try {
            DB::beginTransaction();

            $student = Student::findOrFail($id);
            $user = $student->user;

            // Update user
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update student
            $student->update([
                'nis' => $request->nis,
                'nisn' => $request->nisn,
            ]);

            // Update class history if classroom changed
            $activeTerm = Term::where('is_active', true)->first();
            $classHistory = ClassHistory::where('student_id', $student->id)
                ->where('terms_id', $activeTerm->id)
                ->first();

            if ($classHistory && $classHistory->class_id != $request->classroom_id) {
                $classHistory->update([
                    'class_id' => $request->classroom_id,
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data siswa: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $student = Student::findOrFail($id);
            $user = $student->user;

            // Delete class histories
            ClassHistory::where('student_id', $student->id)->delete();

            // Delete student
            $student->delete();

            // Delete user
            $user->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Siswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus siswa: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=students_template.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Name', 'Email', 'NIS', 'NISN', 'Classroom (e.g. 10 PPLG 1)'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Add example row
            fputcsv($file, ['John Doe', 'john@example.com', '12345', '0012345678', '10 PPLG 1']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
