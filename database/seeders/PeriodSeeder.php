<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Period;

class PeriodSeeder extends Seeder
{
    public function run(): void
    {
        $periods = [
            ['ordinal' => 'Pembiasaan', 'start_time' => '06:30:00', 'end_time' => '07:15:00'],
            ['ordinal' => '1',           'start_time' => '07:15:00', 'end_time' => '07:55:00'],
            ['ordinal' => '2',           'start_time' => '07:55:00', 'end_time' => '08:35:00'],
            ['ordinal' => '3',           'start_time' => '08:35:00', 'end_time' => '09:15:00'],
        ];

        foreach ($periods as $period) {
            Period::updateOrCreate(
                ['ordinal' => $period['ordinal']],
                $period
            );
        }

        $this->command->info('✅ PeriodSeeder: periods created (using start_time & end_time).');
    }
}
