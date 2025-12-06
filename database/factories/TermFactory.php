<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Term>
 */
class TermFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startYear = $this->faker->year();
        return [
            'tahun_ajaran' => $startYear . '/' . ($startYear + 1),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'is_active' => true,
            'kind' => $this->faker->randomElement(['ganjil', 'genap']),
        ];
    }
}
