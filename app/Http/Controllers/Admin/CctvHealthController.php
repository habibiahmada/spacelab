<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class CctvHealthController extends Controller
{
    public function index(Request $request)
    {
        $status = (string) $request->query('status', 'all');
        $perPage = (int) $request->query('per_page', 10);

        if (! in_array($status, ['all', 'online', 'degraded', 'offline', 'unknown'], true)) {
            $status = 'all';
        }
        if (! in_array($perPage, [10, 15, 25, 50], true)) {
            $perPage = 10;
        }

        $buildings = Building::query()
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        $buildingId = (string) $request->query('building_id', 'all');
        $knownBuildingIds = $buildings->pluck('id')->map(fn ($id) => (string) $id)->all();
        if ($buildingId !== 'all' && ! in_array($buildingId, $knownBuildingIds, true)) {
            $buildingId = 'all';
        }

        $rooms = Room::query()
            ->with(['building', 'latestHealthLog'])
            ->when($buildingId !== 'all', fn ($query) => $query->where('building_id', $buildingId))
            ->orderBy('name')
            ->get();

        if ($status !== 'all') {
            $rooms = $rooms->filter(function ($room) use ($status) {
                if ($status === 'unknown') {
                    return ! $room->latestHealthLog;
                }

                return $room->latestHealthLog && $room->latestHealthLog->status === $status;
            })->values();
        }

        $totalFiltered = $rooms->count();
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
        $rooms = $paginatedRooms;

        return view('admin.cctv.health', compact(
            'rooms',
            'buildings',
            'buildingId',
            'status',
            'perPage'
        ));
    }

    public function summary(Request $request)
    {
        $rooms = Room::query()
            ->with('latestHealthLog')
            ->get();

        $totalCameras = $rooms->count();
        $onlineCount = $rooms->filter(fn($r) => $r->latestHealthLog?->status === 'online')->count();
        $degradedCount = $rooms->filter(fn($r) => $r->latestHealthLog?->status === 'degraded')->count();
        $offlineCount = $rooms->filter(fn($r) => $r->latestHealthLog?->status === 'offline')->count();
        $unknownCount = $rooms->filter(fn($r) => !$r->latestHealthLog)->count();

        $offlineOver5Min = $rooms->filter(function ($room) {
            if (!$room->latestHealthLog || $room->latestHealthLog->status !== 'offline') {
                return false;
            }
            return $room->latestHealthLog->checked_at->diffInMinutes(now()) > 5;
        })->count();

        return response()->json([
            'total_cameras' => $totalCameras,
            'online' => $onlineCount,
            'degraded' => $degradedCount,
            'offline' => $offlineCount,
            'unknown' => $unknownCount,
            'offline_over_5min' => $offlineOver5Min,
        ]);
    }
}
