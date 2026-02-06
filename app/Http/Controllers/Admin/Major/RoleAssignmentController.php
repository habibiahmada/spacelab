<?php

namespace App\Http\Controllers\Admin\Major;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\RoleAssignment;
use App\Models\Term;
use Illuminate\Http\Request;

class RoleAssignmentController extends Controller
{
    /**
     * Update role assignment (Head/Coordinator).
     */
    public function update(Request $request, Major $major)
    {
        $request->validate([
            'role_type' => 'required|in:head,coordinator',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $activeTerm = Term::where('is_active', true)->first();
        if (!$activeTerm) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        $assignment = RoleAssignment::firstOrNew([
            'major_id' => $major->id,
            'terms_id' => $activeTerm->id,
        ]);

        if ($request->role_type === 'head') {
            $assignment->head_of_major_id = $request->teacher_id;
        } else {
            $assignment->program_coordinator_id = $request->teacher_id;
        }

        try {
            $assignment->save();
            return redirect()->back()->with('success', 'Penugasan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
