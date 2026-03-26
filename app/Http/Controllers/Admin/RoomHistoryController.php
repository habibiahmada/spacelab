<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Classroom;
use App\Models\Room;
use App\Models\RoomHistory;
use App\Models\Teacher;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; // Perbaikan di sini
use Illuminate\Support\Facades\Auth;

class RoomHistoryController extends Controller
{
    public function index()
    {
        $dayOfWeek = Carbon::now()->dayOfWeekIso;

        // paginate rooms instead of pulling everything in one go
        $roomsQuery = Room::with(['timetableEntries' => function ($query) use ($dayOfWeek) {
            $query->where('day_of_week', $dayOfWeek)
                ->whereHas('template', function ($q) {
                    $q->where('is_active', true);
                })
                ->with(['period', 'teacherSubject.subject', 'teacherSubject.teacher', 'roomHistory.classroom']);
        }]);

        $rooms = $roomsQuery->paginate(10);
        // compute current status on each room in the current page
        $rooms->getCollection()->transform(function ($room) {
            $now = Carbon::now();
            $currentEntry = $room->timetableEntries->first(function ($entry) use ($now) {
                return $entry->isOngoing($now);
            });

            $room->current_status = $currentEntry ? 'Occupied' : 'Empty';
            $room->current_entry = $currentEntry;

            return $room;
        });

        // histories still available for the global modal, but not used on index table
        $histories = RoomHistory::with(['room', 'classroom', 'term', 'teacher'])
            ->latest()
            ->paginate(10);

        $teachers = Teacher::all();
        $classrooms = Classroom::all();
        $terms = Term::all();
        $allRooms = Room::all();

        return view('admin.roomhistory.index', [
            'title' => 'Riwayat Status Ruangan',
            'description' => 'Halaman ringkasan ruangan dan manajemen booking',
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
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Perbaikan di sini
        $validated['user_id'] = Auth::id();

        // Normalize empty strings to null for optional fields
        foreach (['classes_id', 'teacher_id', 'event_type', 'start_date', 'end_date'] as $key) {
            if (array_key_exists($key, $validated) && $validated[$key] === '') {
                $validated[$key] = null;
            }
        }

        RoomHistory::create($validated);

        AuditLog::create([
            'user_id' => Auth::id(),
            'entity' => 'riwayat ruangan ('.$validated['room_id'].')',
            'record_id' => RoomHistory::where('room_id', $validated['room_id'])->latest()->first()->id,
            'action' => 'create_room_history',
            'new_data' => [
                'message' => 'Pengguna '.Auth::user()->name.' menambahkan riwayat ruangan pada '.now()->toDateTimeString(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ],
        ]);

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
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Normalize empty strings to null for optional fields
        foreach (['classes_id', 'teacher_id', 'event_type', 'start_date', 'end_date'] as $key) {
            if (array_key_exists($key, $validated) && $validated[$key] === '') {
                $validated[$key] = null;
            }
        }

        $history->update($validated);

        AuditLog::create([
            'user_id' => Auth::id(),
            'entity' => 'riwayat ruangan ('.$history->room_id.')',
            'record_id' => $history->id,
            'action' => 'update_room_history',
            'new_data' => [
                'message' => 'Pengguna '.Auth::user()->name.' memperbarui riwayat ruangan pada '.now()->toDateTimeString(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ],
        ]);

        // if incoming request came from a room-show page, redirect back there
        $referer = $request->headers->get('referer');
        if ($referer && preg_match('#/room-history/([0-9a-f\-]+)#', $referer, $m)) {
            // $m[1] may be room id
            return redirect()->route('admin.rooms.history.show', $history->room_id)
                ->with('success', 'Room history updated successfully.');
        }

        return redirect()->back()->with('success', 'Room history updated successfully.');
    }

    public function destroy($id)
    {
        $history = RoomHistory::findOrFail($id);
        $roomId = $history->room_id;
        $history->delete();

        // if deletion happened from room-show page, go back to that page
        $referer = request()->headers->get('referer');
        if ($referer && preg_match('#/room-history/([0-9a-f\-]+)#', $referer, $m)) {
            return redirect()->route('admin.rooms.history.show', $roomId)
                ->with('success', 'Room history deleted successfully.');
        }

        return redirect()->back()->with('success', 'Room history deleted successfully.');
    }

    /**
     * Display calendar and bookings for a single room.
     */
    public function show($id)
    {
        $room = Room::with(['roomHistory' => function ($q) {
            $q->with(['classroom', 'term', 'teacher']);
        }])->findOrFail($id);

        // prepare events for the calendar
        $events = $room->roomHistory->filter(function($h){
            return $h->start_date !== null;
        })->map(function ($h) {
            return [
                'id' => $h->id,
                'title' => $h->event_type ?: 'Booking',
                'start' => $h->start_date->toIso8601String(),
                'end' => $h->end_date?->toIso8601String(),
                'classroom' => $h->classroom?->full_name,
                'teacher' => $h->teacher?->name,
                'term' => $h->term?->tahun_ajaran,
            ];
        });

        $teachers = Teacher::all();
        $classrooms = Classroom::all();
        $terms = Term::all();

        return view('admin.roomhistory.show', [
            'title' => 'Jadwal Ruangan '.$room->name,
            'description' => 'Kalender penggunaan dan pemesanan ruangan',
            'room' => $room,
            'events' => $events,
            'teachers' => $teachers,
            'classrooms' => $classrooms,
            'terms' => $terms,
        ]);
    }
}
