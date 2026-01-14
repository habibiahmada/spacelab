<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\TimetableEntry;
use Carbon\Carbon;

class RoomController extends Controller
{
    //
    public function index()
    {
        $todayDay = Carbon::now()->isoWeekday();

        $q = request('q');
        $filter = request('filter');

        $roomsQuery = Room::query()
            ->with(['building', 'timetableEntries' => function ($query) use ($todayDay) {
                $query->where('day_of_week', $todayDay)
                    ->with(['period', 'teacherSubject.teacher', 'teacherSubject.subject', 'roomHistory', 'template.class.major']);
            }])
            ->withCount(['timetableEntries as todays_entries_count' => function ($query) use ($todayDay) {
                $query->where('day_of_week', $todayDay);
            }])
            ->orderBy('name');

        if ($q) {
            $roomsQuery->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            });
        }

        if ($filter === 'occupied') {
            $roomsQuery->whereHas('timetableEntries', function ($query) use ($todayDay) {
                $query->where('day_of_week', $todayDay);
            });
        }

        if ($filter === 'empty') {
            $roomsQuery->whereDoesntHave('timetableEntries', function ($query) use ($todayDay) {
                $query->where('day_of_week', $todayDay);
            });
        }

        $rooms = $roomsQuery->paginate(52)->withQueryString();

        // Today's timetable entries
        $todayEntries = TimetableEntry::with(['roomHistory.room.building', 'period', 'teacherSubject.teacher', 'teacherSubject.subject', 'template.class.major'])
            ->where('day_of_week', $todayDay)
            ->get()
            ->sortBy(fn ($entry) => $entry->period?->start_time ?? '00:00:00');

        $totalRooms = Room::count();
        $todayRoomsCount = $todayEntries->map(fn ($e) => $e->roomHistory?->room?->id)->filter()->unique()->count();
        $todaySubjectsCount = $todayEntries->map(fn ($e) => $e->teacher_subject_id)->filter()->unique()->count();

        $todayRooms = Room::query()
            ->with(['building', 'timetableEntries' => function ($query) use ($todayDay) {
                $query->where('day_of_week', $todayDay)
                    ->with(['period', 'teacherSubject.teacher', 'teacherSubject.subject', 'roomHistory', 'template.class.major']);
            }])
            ->whereHas('timetableEntries', function ($query) use ($todayDay) {
                $query->where('day_of_week', $todayDay);
            })
            ->orderBy('name')
            ->paginate(6)
            ->withQueryString();

        $emptyRoomsCount = Room::query()
            ->whereDoesntHave('timetableEntries', function ($query) use ($todayDay) {
                $query->where('day_of_week', $todayDay);
            })
            ->count();

        return view('student.room', [
            'rooms' => $rooms,
            'todayEntries' => $todayEntries,
            'todayRooms' => $todayRooms,
            'q' => $q,
            'filter' => $filter,
            'totalRooms' => $totalRooms,
            'todayRoomsCount' => $todayRoomsCount,
            'todaySubjectsCount' => $todaySubjectsCount,
            'emptyRoomsCount' => $emptyRoomsCount,
            'title' => 'Ruangan',
            'description' => 'Halaman ruangan',
        ]);
    }
}
