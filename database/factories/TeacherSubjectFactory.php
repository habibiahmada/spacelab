<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherSubjectFactory extends Factory
{
    protected $model = TeacherSubject::class;

    public function definition(): array
    {
        return [
            'teacher_id' => Teacher::factory(),
            'subject_id' => Subject::factory(),
            'started_at' => now(),
            'ended_at' => null,
        ];
    }

    public function ended(): static
    {
        return $this->state(fn (array $attributes) => [
            'ended_at' => now()->addMonths(6),
        ]);
    }
}
