<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\Room;
use App\Models\RoomHistory;
use App\Models\Teacher;
use App\Models\Term;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomHistoryFactory extends Factory
{
    protected $model = RoomHistory::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+6 months');

        return [
            'room_id' => Room::factory(),
            'event_type' => fake()->randomElement(['class_assignment', 'teacher_assignment', 'maintenance']),
            'classes_id' => Classroom::factory(),
            'terms_id' => Term::factory(),
            'teacher_id' => Teacher::factory(),
            'user_id' => User::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }

    public function classAssignment(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_type' => 'class_assignment',
        ]);
    }

    public function teacherAssignment(): static
    {
        return $this->state(fn (array $attributes) => [
            'event_type' => 'teacher_assignment',
        ]);
    }
}
