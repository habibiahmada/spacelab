<?php

namespace App\Http\Controllers\Staff\Classroom;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\ClassHistory;
use App\Models\Classroom;
use App\Models\Term;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Add a student to the classroom.
     */
    public function store(Request $request, $id)
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

    /**
     * Remove a student from the classroom.
     */
    public function destroy($id, $studentId)
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
}
