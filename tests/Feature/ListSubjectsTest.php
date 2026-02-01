<?php

use App\Models\Program;
use App\Models\Subject;
use App\Models\University;

test('it returns empty list when no subjects exist', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index'))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(0, 'data');
});

test('it can list all subjects with university and program', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    $subject = Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index'))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment([
            'subject_id' => $subject->id,
            'name' => $subject->name,
            'code' => $subject->code,
            'semester' => $subject->semester,
            'credit' => $subject->credit,
            'syllabus_url' => $subject->syllabus_url,
        ])
        ->assertJsonFragment([
            'university' => [
                'university_id' => $university->id,
                'name' => $university->name,
                'label' => $university->label,
            ],
        ])
        ->assertJsonFragment([
            'program' => [
                'program_id' => $program->id,
                'name' => $program->name,
                'abbreviation' => $program->abbreviation,
            ],
        ]);
});

test('it paginates subjects at 20 per page', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    Subject::factory()->count(25)->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index'))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(20, 'data');
});

test('it can navigate to second page of subjects', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    Subject::factory()->count(25)->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.subjects.index', ['page' => 2]))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(5, 'data');
});
