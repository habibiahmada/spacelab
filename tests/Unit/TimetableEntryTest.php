<?php

namespace Tests\Unit;

use App\Models\Period;
use App\Models\TimetableEntry;
use Carbon\Carbon;
use Tests\TestCase;

class TimetableEntryTest extends TestCase
{
    public function test_is_ongoing_only_within_daily_time_and_period_range()
    {
        $period = new Period([
            'ordinal' => '3',
            // Keep old date-range for backwards compatibility; but use time-only
            // attributes for weekly recurring behavior.
            'start_date' => '2025-10-01 08:35:00',
            'end_date' => '2025-12-31 09:15:00',
            'start_time' => '08:35:00',
            'end_time' => '09:15:00',
        ]);

        $entry = new TimetableEntry();
        $entry->setRelation('period', $period);

        $now = Carbon::parse('2025-11-29 08:40:00'); // within the daily time 08:35--09:15
        $this->assertTrue($entry->isOngoing($now));
        $this->assertFalse($entry->isPast($now));

        $now = Carbon::parse('2025-11-29 07:00:00'); // before daily time
        $this->assertFalse($entry->isOngoing($now));
        $this->assertFalse($entry->isPast($now));

        $now = Carbon::parse('2025-11-29 09:18:00'); // after daily end time
        $this->assertFalse($entry->isOngoing($now));
        $this->assertTrue($entry->isPast($now));
    }

    public function test_over_midnight_period_is_ongoing()
    {
        $period = new \App\Models\Period([
            'start_time' => '23:00:00',
            'end_time' => '01:00:00',
        ]);
        $entry = new \App\Models\TimetableEntry();
        $entry->setRelation('period', $period);

        $now = Carbon::parse('2025-11-29 23:30:00');
        $this->assertTrue($entry->isOngoing($now));

        $now = Carbon::parse('2025-11-30 00:30:00');
        $this->assertTrue($entry->isOngoing($now));

        $now = Carbon::parse('2025-11-30 02:00:00');
        $this->assertFalse($entry->isOngoing($now));
    }
}
