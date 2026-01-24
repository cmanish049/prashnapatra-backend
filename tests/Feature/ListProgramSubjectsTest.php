<?php

use App\Models\Program;
use App\Models\Subject;
use App\Models\University;

test('it returns empty list when program has no subjects', function (): void {
    $program = Program::factory()->create();

    $this->withApiKey()
        ->getJson(route('api.v1.programs.subjects.index', $program))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(0, 'data');
});

test('it can list subjects for a program', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    $subject = Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.programs.subjects.index', $program))
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
        ]);
});

test('it returns 404 for non-existent program', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.programs.subjects.index', ['programId' => 999]))
        ->assertNotFound()
        ->assertJson([
            'status' => 'error',
            'error' => true,
            'message' => 'Program not found',
        ]);
});

test('it only returns subjects associated with the specified program', function (): void {
    $university = University::factory()->create();
    $program1 = Program::factory()->create();
    $program2 = Program::factory()->create();

    $subject1 = Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program1->id,
    ]);
    Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program2->id,
    ]);

    $this->withApiKey()
        ->getJson(route('api.v1.programs.subjects.index', $program1))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['subject_id' => $subject1->id]);
});
