<?php

namespace Database\Seeders;

use App\Models\CctvCameraPolicy;
use App\Models\Room;
use Illuminate\Database\Seeder;

class CctvCameraPolicySeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::query()
            ->whereIn('camera_type', ['webcam', 'ip_camera'])
            ->whereDoesntHave('cctvPolicy')
            ->get();

        foreach ($rooms as $room) {
            CctvCameraPolicy::create([
                'room_id' => $room->id,
                'segment_seconds' => 300, // 5 minutes
                'retention_days' => 30,
                'record_mode' => 'continuous',
                'heartbeat_interval_seconds' => 60,
                'max_offline_tolerance_seconds' => 180,
                'is_enabled' => true,
            ]);
        }

        $this->command->info('Created default CCTV policies for ' . $rooms->count() . ' rooms');
    }
}
