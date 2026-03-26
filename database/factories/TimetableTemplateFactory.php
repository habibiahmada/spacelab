<?php

namespace Database\Factories;

use App\Models\Block;
use App\Models\Classroom;
use App\Models\TimetableTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimetableTemplateFactory extends Factory
{
    protected $model = TimetableTemplate::class;

    public function definition(): array
    {
        return [
            'class_id' => Classroom::factory(),
            'block_id' => Block::factory(),
            'version' => 1,
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function version(int $version): static
    {
        return $this->state(fn (array $attributes) => [
            'version' => $version,
        ]);
    }
}
