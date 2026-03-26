<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\CctvCameraEvent;
use App\Models\CctvRecordingSegment;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CctvPlaybackController extends Controller
{
    public function index(Request $request)
    {
        $roomId = (string) $request->query('room_id', '');
        if ($roomId === '') {
            $roomId = null;
        }

        $date = $request->query('date', now()->format('Y-m-d'));
        $buildingId = (string) $request->query('building_id', 'all');
        $status = (string) $request->query('status', 'all');

        if (! in_array($status, ['all', 'online', 'degraded', 'offline', 'unknown'], true)) {
            $status = 'all';
        }

        $buildings = Building::query()
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

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

        $selectedRoom = null;
        if ($roomId) {
            $selectedRoom = Room::with(['building', 'latestHealthLog'])->find($roomId);
        }

        return view('admin.cctv.playback', compact(
            'rooms',
            'buildings',
            'selectedRoom',
            'roomId',
            'date',
            'buildingId',
            'status'
        ));
    }

    public function segments(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date',
        ]);

        $roomId = $request->query('room_id');
        $date = Carbon::parse($request->query('date'));
        
        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();

        $segments = CctvRecordingSegment::query()
            ->where('room_id', $roomId)
            ->where('segment_start_at', '>=', $startOfDay)
            ->where('segment_start_at', '<=', $endOfDay)
            ->orderBy('segment_start_at')
            ->get()
            ->map(function (CctvRecordingSegment $segment) {
                return [
                    'id' => $segment->id,
                    'room_id' => $segment->room_id,
                    'camera_type' => $segment->camera_type,
                    'record_mode' => $segment->record_mode,
                    'segment_start_at' => $segment->segment_start_at?->toIso8601String(),
                    'segment_end_at' => $segment->segment_end_at?->toIso8601String(),
                    'duration_seconds' => $segment->duration_seconds,
                    'file_path' => $segment->file_path,
                    'file_size_bytes' => $segment->file_size_bytes,
                    'codec' => $segment->codec,
                    'resolution' => $segment->resolution,
                    'has_motion' => (bool) $segment->has_motion,
                    'integrity_status' => $segment->integrity_status,
                    'playback_url' => route('admin.cctv.playback.stream', ['segment' => $segment->id]),
                ];
            })
            ->values();

        $events = CctvCameraEvent::query()
            ->where('room_id', $roomId)
            ->where('event_at', '>=', $startOfDay)
            ->where('event_at', '<=', $endOfDay)
            ->orderBy('event_at')
            ->get();

        return response()->json([
            'segments' => $segments,
            'events' => $events,
        ]);
    }

    public function stream(CctvRecordingSegment $segment): StreamedResponse
    {
        if (!Storage::disk('local')->exists($segment->file_path)) {
            abort(404, 'Segment file not found.');
        }

        return Storage::disk('local')->response($segment->file_path);
    }
}
