<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Period;

class PeriodSeeder extends Seeder
{
    public function run(): void
    {
        $periods = [
            ['ordinal' => 'P1', 'start_date' => '2025-01-01'],
            ['ordinal' => 'P2', 'start_date' => '2025-04-01'],
            ['ordinal' => 'P3', 'start_date' => '2025-07-01'],
            ['ordinal' => 'P4', 'start_date' => '2025-10-01'],
        ];

        foreach ($periods as $period) {
            Period::updateOrCreate(['ordinal' => $period['ordinal']], $period);
        }

        $this->command->info('✅ PeriodSeeder: periods created.');
    }
}
