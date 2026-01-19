<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\Subject;
use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'university_id' => University::factory(),
            'program_id' => Program::factory(),
            'semester' => fake()->numberBetween(1, 8),
            'credit' => fake()->numberBetween(1, 5),
            'code' => strtoupper(fake()->lexify('???')) . fake()->numerify('###'),
            'syllabus_url' => fake()->url(),
        ];
    }
}
