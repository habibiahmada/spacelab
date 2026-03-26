<?php

namespace App\Console\Commands;

use App\Models\CctvRecordingSegment;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CctvRetentionCleanup extends Command
{
    protected $signature = 'cctv:retention-cleanup';
    protected $description = 'Clean up old CCTV recordings based on retention policy';

    public function handle()
    {
        $this->info('Starting CCTV retention cleanup...');

        $rooms = Room::query()
            ->whereIn('camera_type', ['webcam', 'ip_camera'])
            ->with('cctvPolicy')
            ->get();

        $totalDeleted = 0;
        $totalSizeFreed = 0;

        foreach ($rooms as $room) {
            $policy = $room->cctvPolicy;
            
            if (!$policy || !$policy->is_enabled) {
                continue;
            }

            $retentionDays = $policy->retention_days ?? 30;
            $cutoffDate = Carbon::now()->subDays($retentionDays);

            // Find segments older than retention period
            $oldSegments = CctvRecordingSegment::query()
                ->where('room_id', $room->id)
                ->where('segment_start_at', '<', $cutoffDate)
                ->get();

            foreach ($oldSegments as $segment) {
                // Delete file from storage
                if (Storage::disk('local')->exists($segment->file_path)) {
                    Storage::disk('local')->delete($segment->file_path);
                }

                $totalSizeFreed += $segment->file_size_bytes ?? 0;
                $segment->delete();
                $totalDeleted++;
            }
        }

        $sizeMB = round($totalSizeFreed / (1024 * 1024), 2);
        $this->info("Cleanup completed: {$totalDeleted} segments deleted, {$sizeMB} MB freed");

        return Command::SUCCESS;
    }
}
