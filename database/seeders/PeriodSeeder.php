<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Period;

class PeriodSeeder extends Seeder
{
    public function run(): void
    {
        // NOTE:
        // - 'code' is unique identifier (better than relying on ordinal text)
        // - 'is_teaching' -> false untuk istirahat/pembiasaan/pulang
        $periods = [
            ['ordinal' => 'Pembiasaan', 'start_time' => '06:30:00', 'end_time' => '07:15:00', 'is_teaching' => false],
            ['ordinal' => '1', 'start_time' => '07:15:00', 'end_time' => '07:55:00', 'is_teaching' => true],
            ['ordinal' => '2', 'start_time' => '07:55:00', 'end_time' => '08:35:00', 'is_teaching' => true],
            ['ordinal' => '3', 'start_time' => '08:35:00', 'end_time' => '09:15:00', 'is_teaching' => true],
            ['ordinal' => 'Istirahat Pagi', 'start_time' => '09:15:00', 'end_time' => '09:30:00', 'is_teaching' => false],
            ['ordinal' => '4', 'start_time' => '09:30:00', 'end_time' => '10:10:00', 'is_teaching' => true],
            ['ordinal' => '5', 'start_time' => '10:10:00', 'end_time' => '10:50:00', 'is_teaching' => true],
            ['ordinal' => '6', 'start_time' => '10:50:00', 'end_time' => '11:30:00', 'is_teaching' => true],
            ['ordinal' => '7', 'start_time' => '11:30:00', 'end_time' => '12:00:00', 'is_teaching' => true],
            ['ordinal' => 'Istirahat Siang', 'start_time' => '12:00:00', 'end_time' => '12:50:00', 'is_teaching' => false],
            ['ordinal' => '8', 'start_time' => '12:50:00', 'end_time' => '13:30:00', 'is_teaching' => true],
            ['ordinal' => '9', 'start_time' => '13:30:00', 'end_time' => '14:10:00', 'is_teaching' => true],
            ['ordinal' => '10', 'start_time' => '14:10:00', 'end_time' => '14:50:00', 'is_teaching' => true],
            ['ordinal' => 'Pulang', 'start_time' => '14:50:00', 'end_time' => '17:30:00', 'is_teaching' => false],
        ];

        foreach ($periods as $p) {
            Period::updateOrCreate(
                [
                    'ordinal' => $p['ordinal'],
                    'start_time' => $p['start_time'],
                    'end_time' => $p['end_time'],
                    'is_teaching' => $p['is_teaching'],
                ]
            );
        }

        $this->command->info('✅ PeriodSeeder: periods created/updated (with is_teaching & code).');
    }
}
