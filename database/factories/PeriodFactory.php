<?php

namespace Database\Factories;

use App\Models\Period;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodFactory extends Factory
{
    protected $model = Period::class;

    public function definition(): array
    {
        $startHour = fake()->numberBetween(7, 15);
        $startTime = sprintf('%02d:00:00', $startHour);
        $endTime = sprintf('%02d:00:00', $startHour + 1);

        return [
            'ordinal' => fake()->numberBetween(1, 10),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'is_teaching' => true,
        ];
    }

    public function nonTeaching(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_teaching' => false,
        ]);
    }
}
