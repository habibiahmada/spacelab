<?php

namespace App\Http\Controllers\Admin\Classroom;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\GuardianClassHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    /**
     * Update/Set Guardian for a classroom.
     */
    public function update(Request $request, $id)
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
}
