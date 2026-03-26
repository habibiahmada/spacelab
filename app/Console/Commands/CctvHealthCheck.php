<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use App\Models\CctvCameraEvent;
use App\Models\CctvCameraHealthLog;
use App\Models\Notification;
use App\Models\Room;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CctvHealthCheck extends Command
{
    protected $signature = 'cctv:health-check';
    protected $description = 'Check health status of all CCTV cameras';

    public function handle()
    {
        $this->info('Starting CCTV health check...');

        $rooms = Room::query()
            ->whereIn('camera_type', ['webcam', 'ip_camera'])
            ->where('is_camera_active', true)
            ->with('cctvPolicy', 'latestHealthLog')
            ->get();

        $checked = 0;
        $online = 0;
        $degraded = 0;
        $offline = 0;

        foreach ($rooms as $room) {
            $status = $this->checkCameraStatus($room);
            
            if ($status['status'] === 'online') {
                $online++;
            } elseif ($status['status'] === 'degraded') {
                $degraded++;
            } else {
                $offline++;
            }

            // Save health log
            CctvCameraHealthLog::create([
                'room_id' => $room->id,
                'checked_at' => now(),
                'status' => $status['status'],
                'response_ms' => $status['response_ms'],
                'error_code' => $status['error_code'],
                'error_message' => $status['error_message'],
            ]);

            // Check for status change and create event
            $previousStatus = $room->latestHealthLog?->status;
            if ($previousStatus && $previousStatus !== $status['status']) {
                $eventType = $status['status'] === 'online' ? 'online' : 'offline';
                $severity = $status['status'] === 'offline' ? 'critical' : 'info';

                $event = CctvCameraEvent::create([
                    'room_id' => $room->id,
                    'event_type' => $eventType,
                    'event_at' => now(),
                    'severity' => $severity,
                    'payload' => [
                        'previous_status' => $previousStatus,
                        'new_status' => $status['status'],
                        'error_message' => $status['error_message'],
                    ],
                ]);

                $this->notifyAdminsForStatusChange($room, $previousStatus, $status['status'], $status['error_message']);
                $this->writeAuditLog($room, $event, $previousStatus, $status['status'], $status['error_message']);
            }

            $checked++;
        }

        $this->info("Health check completed: {$checked} cameras checked");
        $this->info("Online: {$online}, Degraded: {$degraded}, Offline: {$offline}");

        return Command::SUCCESS;
    }

    private function notifyAdminsForStatusChange(Room $room, string $previousStatus, string $currentStatus, ?string $errorMessage): void
    {
        $statusLabel = strtoupper($currentStatus);
        $message = 'CCTV ' . $room->name . ' berubah dari ' . $previousStatus . ' ke ' . $statusLabel . '.';
        if ($errorMessage) {
            $message .= ' Detail: ' . $errorMessage;
        }

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

    private function writeAuditLog(Room $room, CctvCameraEvent $event, string $previousStatus, string $currentStatus, ?string $errorMessage): void
    {
        AuditLog::create([
            'user_id' => null,
            'entity' => 'cctv_camera_health_logs',
            'record_id' => $event->id,
            'action' => 'update',
            'new_data' => [
                'room_id' => $room->id,
                'room_name' => $room->name,
                'previous_status' => $previousStatus,
                'current_status' => $currentStatus,
                'error_message' => $errorMessage,
                'triggered_by' => 'scheduler:cctv:health-check',
            ],
        ]);
    }

    private function checkCameraStatus(Room $room): array
    {
        $startTime = microtime(true);
        
        try {
            if ($room->camera_type === 'ip_camera' && $room->stream_url) {
                // Try to ping the IP camera stream
                $response = Http::timeout(5)->head($room->stream_url);
                $responseTime = (microtime(true) - $startTime) * 1000;

                if ($response->successful()) {
                    if ($responseTime > 2000) {
                        return [
                            'status' => 'degraded',
                            'response_ms' => (int) $responseTime,
                            'error_code' => null,
                            'error_message' => 'Slow response time',
                        ];
                    }

                    return [
                        'status' => 'online',
                        'response_ms' => (int) $responseTime,
                        'error_code' => null,
                        'error_message' => null,
                    ];
                }

                return [
                    'status' => 'offline',
                    'response_ms' => (int) $responseTime,
                    'error_code' => (string) $response->status(),
                    'error_message' => 'HTTP error: ' . $response->status(),
                ];
            }

            // For webcam, we can't really check from server side
            // So we assume it's online if it's configured
            return [
                'status' => 'online',
                'response_ms' => null,
                'error_code' => null,
                'error_message' => null,
            ];

        } catch (\Exception $e) {
            $responseTime = (microtime(true) - $startTime) * 1000;

            return [
                'status' => 'offline',
                'response_ms' => (int) $responseTime,
                'error_code' => 'EXCEPTION',
                'error_message' => $e->getMessage(),
            ];
        }
    }
}
