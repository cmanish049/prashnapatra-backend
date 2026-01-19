<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\QuestionPaper;
use App\Models\Subject;
use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuestionPaper>
 */
class QuestionPaperFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject_id' => Subject::factory(),
            'university_id' => University::factory(),
            'program_id' => Program::factory(),
            'semester' => fake()->numberBetween(1, 8),
            'file_path' => null,
            'file_url' => null,
            'year' => fake()->year(),
        ];
    }
}
