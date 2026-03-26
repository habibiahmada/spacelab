<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\CctvCameraEvent;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CctvEventController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'room_id' => 'nullable|exists:rooms,id',
            'event_type' => 'nullable|in:offline,online,recording_started,recording_failed,gap_detected,manual_bookmark',
            'severity' => 'nullable|in:info,warning,critical',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $perPage = (int) ($validated['per_page'] ?? 20);

        $events = CctvCameraEvent::query()
            ->with(['room.building', 'creator'])
            ->when(isset($validated['room_id']), fn($query) => $query->where('room_id', $validated['room_id']))
            ->when(isset($validated['event_type']), fn($query) => $query->where('event_type', $validated['event_type']))
            ->when(isset($validated['severity']), fn($query) => $query->where('severity', $validated['severity']))
            ->when(isset($validated['date_from']), fn($query) => $query->where('event_at', '>=', Carbon::parse($validated['date_from'])->startOfDay()))
            ->when(isset($validated['date_to']), fn($query) => $query->where('event_at', '<=', Carbon::parse($validated['date_to'])->endOfDay()))
            ->orderByDesc('event_at')
            ->paginate($perPage)
            ->withQueryString();

        return response()->json($events);
    }

    public function bookmark(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'event_at' => 'nullable|date',
            'severity' => 'nullable|in:info,warning,critical',
            'note' => 'nullable|string|max:1000',
        ]);

        $eventAt = isset($validated['event_at']) ? Carbon::parse($validated['event_at']) : now();
        $severity = $validated['severity'] ?? 'info';
        $note = trim((string) ($validated['note'] ?? ''));

        $event = CctvCameraEvent::create([
            'room_id' => $validated['room_id'],
            'event_type' => 'manual_bookmark',
            'event_at' => $eventAt,
            'severity' => $severity,
            'payload' => [
                'note' => $note !== '' ? $note : null,
            ],
            'created_by' => Auth::id(),
        ]);

        $event->load('room');

        AuditLog::create([
            'user_id' => Auth::id(),
            'entity' => 'cctv_camera_events',
            'record_id' => $event->id,
            'action' => 'create',
            'new_data' => [
                'event_type' => $event->event_type,
                'severity' => $event->severity,
                'room_id' => $event->room_id,
                'room_name' => optional($event->room)->name,
                'event_at' => $event->event_at?->toDateTimeString(),
                'note' => $note !== '' ? $note : null,
            ],
        ]);

        $this->notifyAdminsForBookmark($event, $note);

        $message = 'Bookmark CCTV berhasil disimpan.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'event' => $event,
            ]);
        }

        return back()->with('success', $message);
    }

    private function notifyAdminsForBookmark(CctvCameraEvent $event, string $note): void
    {
        $roomLabel = optional($event->room)->name ?? 'Ruangan tidak diketahui';
        $noteText = $note !== '' ? ' | Catatan: ' . $note : '';
        $message = 'Bookmark CCTV: ' . $roomLabel . ' pada ' . $event->event_at->format('d M Y H:i') . $noteText;

        $adminIds = User::query()
            ->whereHas('role', fn($query) => $query->whereRaw('LOWER(name) = ?', ['admin']))
            ->pluck('id');

        foreach ($adminIds as $adminId) {
            Notification::create([
                'user_id' => $adminId,
                'type' => 'info',
                'message' => $message,
                'is_read' => false,
            ]);
        }
    }
}

