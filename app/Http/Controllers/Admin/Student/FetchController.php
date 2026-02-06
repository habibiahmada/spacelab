<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassHistory;
use App\Models\Term;
use Illuminate\Http\Request;

class FetchController extends Controller
{
    /**
     * Fetch students via AJAX.
     */
    public function __invoke(Request $request)
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
}
