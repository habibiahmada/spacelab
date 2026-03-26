<?php

namespace App\Console\Commands;

use App\Models\CctvRecordingSegment;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CctvSegmentIndexSync extends Command
{
    protected $signature = 'cctv:segment-index-sync {--room= : Sync hanya untuk room_id tertentu} {--dry-run : Simulasi tanpa insert}';

    protected $description = 'Sync metadata segment CCTV dari storage ke database';

    public function handle(): int
    {
        $roomFilter = (string) $this->option('room');
        $dryRun = (bool) $this->option('dry-run');

        $disk = Storage::disk('local');
        $allFiles = $disk->allFiles('cctv');

        $rooms = Room::query()
            ->with('cctvPolicy')
            ->get()
            ->keyBy('id');

        $created = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($allFiles as $filePath) {
            if (!preg_match('/\.(mp4|webm|mkv)$/i', $filePath)) {
                $skipped++;
                continue;
            }

            if (!preg_match('#^cctv/([^/]+)/(\d{4})/(\d{2})/(\d{2})/(\d{2})/(\d{2})-(\d{2})-(\d{2})\.(mp4|webm|mkv)$#i', $filePath, $matches)) {
                $skipped++;
                continue;
            }

            $roomId = $matches[1];
            if ($roomFilter !== '' && $roomFilter !== $roomId) {
                $skipped++;
                continue;
            }

            /** @var \App\Models\Room|null $room */
            $room = $rooms->get($roomId);
            if (! $room) {
                $errors++;
                $this->warn("Room tidak ditemukan untuk file: {$filePath}");
                continue;
            }

            $alreadyExists = CctvRecordingSegment::query()
                ->where('file_path', $filePath)
                ->exists();
            if ($alreadyExists) {
                $skipped++;
                continue;
            }

            try {
                $startAt = Carbon::create(
                    (int) $matches[2],
                    (int) $matches[3],
                    (int) $matches[4],
                    (int) $matches[6],
                    (int) $matches[7],
                    (int) $matches[8]
                );

                $segmentSeconds = (int) ($room->cctvPolicy->segment_seconds ?? 300);
                if ($segmentSeconds <= 0) {
                    $segmentSeconds = 300;
                }

                $endAt = $startAt->copy()->addSeconds($segmentSeconds);
                $fileSize = $disk->size($filePath);
                $cameraType = in_array($room->camera_type, ['webcam', 'ip_camera'], true)
                    ? $room->camera_type
                    : 'ip_camera';
                $recordMode = $room->cctvPolicy->record_mode ?? 'continuous';

                if (! $dryRun) {
                    CctvRecordingSegment::create([
                        'room_id' => $room->id,
                        'camera_type' => $cameraType,
                        'record_mode' => $recordMode,
                        'segment_start_at' => $startAt,
                        'segment_end_at' => $endAt,
                        'duration_seconds' => $segmentSeconds,
                        'file_path' => $filePath,
                        'file_size_bytes' => $fileSize,
                        'codec' => null,
                        'resolution' => null,
                        'has_motion' => false,
                        'integrity_status' => 'ok',
                    ]);
                }

                $created++;
            } catch (\Throwable $th) {
                $errors++;
                $this->error("Gagal sinkron file {$filePath}: {$th->getMessage()}");
            }
        }

        $modeLabel = $dryRun ? ' (dry-run)' : '';
        $this->info("Segment sync selesai{$modeLabel}. created={$created}, skipped={$skipped}, errors={$errors}");

        return self::SUCCESS;
    }
}

