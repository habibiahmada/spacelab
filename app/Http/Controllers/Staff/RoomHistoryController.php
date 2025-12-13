<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomHistory;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\Term;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class RoomHistoryController extends Controller
{

    public function index()
    {
        $dayOfWeek = Carbon::now()->dayOfWeekIso; // 1 = Mon, 7 = Sun

        // Fetch rooms with today's schedule to determine status
        $rooms = Room::with(['timetableEntries' => function ($query) use ($dayOfWeek) {
            $query->where('day_of_week', $dayOfWeek)
                  ->whereHas('template', function ($q) {
                      $q->where('is_active', true);
                  })
                  ->with(['period', 'teacherSubject.subject', 'teacherSubject.teacher', 'roomHistory.classroom']);
        }])->get();

        // Process rooms to determine current status
        $rooms = $rooms->map(function ($room) {
            $now = Carbon::now();
            $currentEntry = $room->timetableEntries->first(function ($entry) use ($now) {
                return $entry->isOngoing($now);
            });

            $room->current_status = $currentEntry ? 'Occupied' : 'Empty';
            $room->current_entry = $currentEntry;
            return $room;
        });

        $histories = RoomHistory::with(['room', 'classroom', 'term', 'teacher'])
            ->latest()
            ->paginate(10);

        $teachers = Teacher::all();
        $classrooms = Classroom::all();
        $terms = Term::all();
        $allRooms = Room::all(); // For dropdown

        return view('staff.roomhistory.index', [
            'title' => 'Riwayat Ruangan',
            'description' => 'Halaman riwayat ruangan dan penggunaan saat ini',
            'rooms' => $rooms,
            'histories' => $histories,
            'teachers' => $teachers,
            'classrooms' => $classrooms,
            'terms' => $terms,
            'allRooms' => $allRooms,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'classes_id' => 'nullable|exists:classes,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'terms_id' => 'required|exists:terms,id',
            'event_type' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        RoomHistory::create($validated);

        return redirect()->back()->with('success', 'Room history created successfully.');
    }

    public function update(Request $request, $id)
    {
        $history = RoomHistory::findOrFail($id);

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'classes_id' => 'nullable|exists:classes,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'terms_id' => 'required|exists:terms,id',
            'event_type' => 'nullable|string',
        ]);

        $history->update($validated);

        return redirect()->back()->with('success', 'Room history updated successfully.');
    }

    public function destroy($id)
    {
        $history = RoomHistory::findOrFail($id);
        $history->delete();

        return redirect()->back()->with('success', 'Room history deleted successfully.');
    }
}
