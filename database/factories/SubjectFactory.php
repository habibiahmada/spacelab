<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        return [
            'code' => fake()->unique()->bothify('??###'),
            'name' => fake()->words(3, true),
            'type' => fake()->randomElement(['teori', 'praktikum', 'lainnya']),
            'description' => fake()->sentence(),
        ];
    }
}
