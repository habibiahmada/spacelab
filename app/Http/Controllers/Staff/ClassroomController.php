<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Major;
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

    public function show($id)
    {
        $classroom = Classroom::with('major')->findOrFail($id);
        return response()->json($classroom);
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
