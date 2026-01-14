<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Major;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subject::query()
            ->with(['majors', 'teachers.user'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        $majors = Major::orderBy('name')->get();

        $teachers = Teacher::with('user')->get()->sortBy(function($teacher) {
            return $teacher->user->name;
        });

        return view('staff.subjects.index', compact('subjects', 'majors', 'teachers'));
    }

    public function fetch(Request $request)
    {
        $query = Subject::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        }

        return response()->json($query->limit(20)->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:subjects,code|max:20',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:teori,praktikum,lainnya',
            'description' => 'nullable|string',
        ]);

        Subject::create($validated);

        return redirect()->back()->with('success', 'Subject created successfully.');
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', Rule::unique('subjects')->ignore($subject->id)],
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:teori,praktikum,lainnya',
            'description' => 'nullable|string',
        ]);

        $subject->update($validated);

        return redirect()->back()->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->back()->with('success', 'Subject deleted successfully.');
    }

    public function updateMajors(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'majors' => 'array',
            'majors.*' => 'exists:majors,id',
        ]);

        // Sync with Pivot notes? For now just sync IDs.
        // If we want to preserve notes, we'd need a more complex UI.
        // Assuming simple toggling for now.
        $subject->majors()->sync($request->majors ?? []);

        return redirect()->back()->with('success', 'Subject majors updated successfully.');
    }

    public function updateTeachers(Request $request, Subject $subject)
    {
        // This is a bit more complex because teacher_subjects table has started_at and ended_at,
        // and it's not a standard pivot table in the content of "sync" if we want to keep history.
        // However, usually "sync" is used for "currently active".
        // Let's check TeacherSubject model. It has start/end dates.
        // For simplicity in this iteration, we will just managing "assignments".
        // Use sync for simplicity, or customized logic if we want to track history.
        // Based on the user request "CRUD lengkap", simple assignment (sync) is a good start.

        $validated = $request->validate([
            'teachers' => 'array',
            'teachers.*' => 'exists:teachers,id',
        ]);

        $subject->teachers()->sync($request->teachers ?? []);

        return redirect()->back()->with('success', 'Subject teachers updated successfully.');
    }
}
