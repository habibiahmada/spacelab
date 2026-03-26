<?php

namespace Database\Factories;

use App\Models\Period;
use App\Models\RoomHistory;
use App\Models\TeacherSubject;
use App\Models\TimetableEntry;
use App\Models\TimetableTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimetableEntryFactory extends Factory
{
    protected $model = TimetableEntry::class;

    public function definition(): array
    {
        return [
            'template_id' => TimetableTemplate::factory(),
            'day_of_week' => fake()->numberBetween(1, 7),
            'period_id' => Period::factory(),
            'teacher_subject_id' => TeacherSubject::factory(),
            'room_history_id' => RoomHistory::factory(),
        ];
    }

    public function forDay(int $day): static
    {
        return $this->state(fn (array $attributes) => [
            'day_of_week' => $day,
        ]);
    }
}
