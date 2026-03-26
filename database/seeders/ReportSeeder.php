<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Room;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $room = Room::where('code', 'GBR-LAB1')->first();

        if ($room) {
            Report::create([
                'room_id' => $room->id,
                'date' => '2025-01-31',
                'total_usage_hours' => 20,
                'total_idle_hours' => 10,
                'utilization_rate' => 66.7,
                'generated_at' => now(),
            ]);
        }

        $this->command->info('✅ ReportSeeder: Reports seeded successfully.');
    }
}
