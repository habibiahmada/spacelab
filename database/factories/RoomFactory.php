<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('R###'),
            'name' => 'Ruang ' . $this->faker->words(2, true),
            'building_id' => Building::factory(),
            'floor' => $this->faker->numberBetween(1, 4),
            'capacity' => $this->faker->numberBetween(20, 50),
            'type' => $this->faker->randomElement(['kelas', 'lab', 'aula', 'lainnya']),
            'is_active' => true,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
