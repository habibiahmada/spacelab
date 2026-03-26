<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Building;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CctvController extends Controller
{
    public function index(Request $request)
    {
        $now        = Carbon::now();
        $dayOfWeek  = $now->isoWeekday();
        $search = trim((string) $request->query('search', ''));
        $cameraType = (string) $request->query('camera_type', 'all');
        $roomStatus = (string) $request->query('room_status', 'all');
        $buildingId = (string) $request->query('building_id', 'all');
        $perPage = (int) $request->query('per_page', 10);

        if (!in_array($cameraType, ['all', 'none', 'webcam', 'ip_camera'], true)) {
            $cameraType = 'all';
        }

        if (!in_array($roomStatus, ['all', 'active', 'empty'], true)) {
            $roomStatus = 'all';
        }

        if (!in_array($perPage, [10, 15, 25, 50], true)) {
            $perPage = 10;
        }

        $roomsQuery = Room::query()->with([
            'building',
            'latestHealthLog',
            'roomHistories' => function ($query) use ($now) {
                $query->whereDate('start_date', '<=', $now)
                      ->whereDate('end_date', '>=', $now)
                      ->orderByDesc('start_date');
            },
            'roomHistories.classroom.major',
            'roomHistories.timetableEntries' => function ($query) use ($dayOfWeek) {
                $query->where('day_of_week', $dayOfWeek)
                      ->whereHas('template', fn($q) => $q->where('is_active', true));
            },
            'roomHistories.timetableEntries.period',
            'roomHistories.timetableEntries.teacherSubject.teacher',
            'roomHistories.timetableEntries.teacherSubject.subject',
            'roomHistories.timetableEntries.template.class.major',
        ]);

        if ($cameraType !== 'all') {
            if ($cameraType === 'none') {
                $roomsQuery->where(function ($query) {
                    $query->where('camera_type', 'none')
                        ->orWhereNull('camera_type');
                });
            } else {
                $roomsQuery->where('camera_type', $cameraType);
            }
        }

        if ($buildingId !== 'all') {
            $roomsQuery->where('building_id', $buildingId);
        }

        $rooms = $roomsQuery->get();

        foreach ($rooms as $room) {
            $room->activeEntry = null;
            foreach ($room->roomHistories as $history) {
                foreach ($history->timetableEntries as $entry) {
                    if ($entry->isOngoing($now)) {
                        $room->activeEntry = $entry;
                        break 2;
                    }
                }
            }
        }

        if ($search !== '') {
            $needle = mb_strtolower($search);
            $rooms = $rooms->filter(function ($room) use ($needle) {
                $entry = $room->activeEntry;
                $classroom = $entry ? optional($entry->template)->class : null;
                $teacher = $entry ? optional($entry->teacherSubject)->teacher : null;
                $subject = $entry ? optional($entry->teacherSubject)->subject : null;
                $major = $classroom?->major;

                $haystack = collect([
                    $room->name,
                    $room->code,
                    optional($room->building)->name,
                    $classroom?->name,
                    $teacher?->name,
                    $subject?->name,
                    $major?->name,
                    $major?->code,
                ])
                    ->filter()
                    ->map(fn($value) => mb_strtolower((string) $value))
                    ->implode(' ');

                return str_contains($haystack, $needle);
            });
        }

        if ($roomStatus === 'active') {
            $rooms = $rooms->filter(fn($room) => $room->activeEntry !== null);
        }

        if ($roomStatus === 'empty') {
            $rooms = $rooms->filter(fn($room) => $room->activeEntry === null);
        }

        $rooms = $rooms->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->values();

        $totalFiltered = $rooms->count();
        $configuredCount = $rooms->filter(fn($room) => in_array($room->camera_type, ['webcam', 'ip_camera'], true))->count();
        $noCameraCount = $rooms->filter(fn($room) => in_array($room->camera_type, [null, 'none'], true))->count();
        $activeRoomCount = $rooms->filter(fn($room) => $room->activeEntry !== null)->count();
        $emptyRoomCount = $totalFiltered - $activeRoomCount;
        
        $onlineCount = $rooms->filter(fn($room) => $room->latestHealthLog?->status === 'online')->count();
        $offlineCount = $rooms->filter(fn($room) => $room->latestHealthLog?->status === 'offline')->count();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginatedRooms = new LengthAwarePaginator(
            $rooms->forPage($currentPage, $perPage)->values(),
            $totalFiltered,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        $buildings = Building::query()
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return view('admin.cctv.index', [
            'rooms' => $paginatedRooms,
            'search' => $search,
            'cameraType' => $cameraType,
            'roomStatus' => $roomStatus,
            'buildingId' => $buildingId,
            'perPage' => $perPage,
            'buildings' => $buildings,
            'totalFiltered' => $totalFiltered,
            'configuredCount' => $configuredCount,
            'noCameraCount' => $noCameraCount,
            'activeRoomCount' => $activeRoomCount,
            'emptyRoomCount' => $emptyRoomCount,
            'onlineCount' => $onlineCount,
            'offlineCount' => $offlineCount,
        ]);
    }

    public function settings(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $cameraType = (string) $request->query('camera_type', 'all');
        $cameraStatus = (string) $request->query('camera_status', 'all');
        $buildingId = (string) $request->query('building_id', 'all');
        $perPage = (int) $request->query('per_page', 10);

        if (!in_array($cameraType, ['all', 'none', 'webcam', 'ip_camera'], true)) {
            $cameraType = 'all';
        }

        if (!in_array($cameraStatus, ['all', 'active', 'inactive'], true)) {
            $cameraStatus = 'all';
        }

        if (!in_array($perPage, [10, 15, 25, 50], true)) {
            $perPage = 10;
        }

        $roomsQuery = Room::query()->with('building');

        if ($search !== '') {
            $roomsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%')
                    ->orWhereHas('building', fn($buildingQuery) => $buildingQuery->where('name', 'like', '%' . $search . '%'));
            });
        }

        if ($cameraType !== 'all') {
            if ($cameraType === 'none') {
                $roomsQuery->where(function ($query) {
                    $query->where('camera_type', 'none')
                        ->orWhereNull('camera_type');
                });
            } else {
                $roomsQuery->where('camera_type', $cameraType);
            }
        }

        if ($cameraStatus === 'active') {
            $roomsQuery->where('is_camera_active', true);
        }

        if ($cameraStatus === 'inactive') {
            $roomsQuery->where('is_camera_active', false);
        }

        if ($buildingId !== 'all') {
            $roomsQuery->where('building_id', $buildingId);
        }

        $totalFiltered = (clone $roomsQuery)->count();
        $configuredCount = (clone $roomsQuery)->whereIn('camera_type', ['webcam', 'ip_camera'])->count();
        $noCameraCount = (clone $roomsQuery)->where(function ($query) {
            $query->where('camera_type', 'none')
                ->orWhereNull('camera_type');
        })->count();
        $ipCameraCount = (clone $roomsQuery)->where('camera_type', 'ip_camera')->count();
        $activeCount = (clone $roomsQuery)->where('is_camera_active', true)->count();

        $rooms = $roomsQuery
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();

        $buildings = Building::query()
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return view('admin.cctv.settings', compact(
            'rooms',
            'search',
            'cameraType',
            'cameraStatus',
            'buildingId',
            'perPage',
            'buildings',
            'configuredCount',
            'totalFiltered',
            'noCameraCount',
            'ipCameraCount',
            'activeCount'
        ));
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'room_id'          => 'required|exists:rooms,id',
            'camera_type'      => 'required|in:none,webcam,ip_camera',
            'stream_url'       => 'nullable|url|required_if:camera_type,ip_camera',
            'is_camera_active' => 'boolean',
        ]);

        $room = Room::findOrFail($request->room_id);
        $oldData = [
            'camera_type' => $room->camera_type,
            'stream_url' => $room->stream_url,
            'is_camera_active' => (bool) $room->is_camera_active,
        ];

        $room->camera_type      = $request->camera_type;
        $room->stream_url       = $request->camera_type === 'ip_camera' ? $request->stream_url : null;
        $room->is_camera_active = $request->boolean('is_camera_active');
        $room->save();

        AuditLog::create([
            'user_id' => Auth::id(),
            'entity' => 'rooms',
            'record_id' => $room->id,
            'action' => 'update',
            'old_data' => $oldData,
            'new_data' => [
                'camera_type' => $room->camera_type,
                'stream_url' => $room->stream_url,
                'is_camera_active' => (bool) $room->is_camera_active,
            ],
        ]);

        $message = 'Pengaturan kamera ' . $room->name . ' berhasil disimpan.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'room'    => [
                    'id'               => $room->id,
                    'name'             => $room->name,
                    'camera_type'      => $room->camera_type,
                    'stream_url'       => $room->stream_url,
                    'is_camera_active' => $room->is_camera_active,
                ],
            ]);
        }

        $redirectParams = collect([
            'search' => $request->input('search'),
            'camera_type' => $request->input('filter_camera_type'),
            'camera_status' => $request->input('filter_camera_status'),
            'building_id' => $request->input('filter_building_id'),
            'per_page' => $request->input('filter_per_page'),
            'page' => $request->input('filter_page'),
        ])
            ->filter(fn($value) => $value !== null && $value !== '')
            ->all();

        return redirect()->route('admin.cctv.settings.index', $redirectParams)->with('success', $message);
    }

}
