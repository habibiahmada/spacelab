<?php

namespace Database\Factories;

use App\Models\Block;
use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlockFactory extends Factory
{
    protected $model = Block::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+3 months');

        return [
            'terms_id' => Term::factory(),
            'name' => fake()->randomElement(['Blok 1', 'Blok 2', 'Blok 3', 'Blok 4']),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
