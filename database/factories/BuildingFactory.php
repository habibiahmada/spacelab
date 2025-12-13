<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
class BuildingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('GD#'),
            'name' => 'Gedung ' . $this->faker->unique()->randomLetter(),
            'description' => $this->faker->sentence(),
            'total_floors' => $this->faker->numberBetween(1, 5),
        ];
    }
}
