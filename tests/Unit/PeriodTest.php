<?php

namespace Tests\Unit;

use App\Models\Period;
use Carbon\Carbon;
use Tests\TestCase;

class PeriodTest extends TestCase
{
    public function test_period_is_ongoing_when_now_between_start_and_end()
    {
        $now = Carbon::now();
        $period = new Period([
            'start_date' => $now->copy()->subMinutes(15),
            'end_date' => $now->copy()->addMinutes(30),
        ]);

        $this->assertTrue($period->isOngoing($now));
        $this->assertFalse($period->isPast($now));
    }

    public function test_period_is_past_when_now_is_after_end()
    {
        $now = Carbon::now();
        $period = new Period([
            'start_date' => $now->copy()->subHours(2),
            'end_date' => $now->copy()->subMinutes(1),
        ]);

        $this->assertFalse($period->isOngoing($now));
        $this->assertTrue($period->isPast($now));
    }

    public function test_period_is_not_ongoing_when_now_is_before_start()
    {
        $now = Carbon::now();
        $period = new Period([
            'start_date' => $now->copy()->addMinutes(20),
            'end_date' => $now->copy()->addHours(1),
        ]);

        $this->assertFalse($period->isOngoing($now));
        $this->assertFalse($period->isPast($now));
    }

    public function test_period_time_only_recurs_every_week()
    {
        $now = Carbon::parse('2025-11-29 08:50:00');
        $period = new Period([
            'start_time' => '08:35:00',
            'end_time' => '09:15:00',
        ]);

        $this->assertTrue($period->isOngoing($now));
        $this->assertFalse($period->isPast($now));
    }

    public function test_period_time_only_over_midnight()
    {
        $period = new Period([
            'start_time' => '23:00:00',
            'end_time' => '01:00:00',
        ]);

        $now = Carbon::parse('2025-11-29 23:30:00');
        $this->assertTrue($period->isOngoing($now));

        $now = Carbon::parse('2025-11-30 00:30:00');
        $this->assertTrue($period->isOngoing($now));

        $now = Carbon::parse('2025-11-30 02:00:00');
        $this->assertFalse($period->isOngoing($now));
    }
}
