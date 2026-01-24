<?php

use App\Models\Program;
use App\Models\Subject;
use App\Models\University;

test('it returns empty list when program has no subjects', function () {
    $program = Program::factory()->create();

    $response = $this->getJson(route('api.v1.programs.subjects.index', $program));

    $response->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(0, 'data');
});

test('it can list subjects for a program', function () {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    $subject = Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program->id,
    ]);

    $response = $this->getJson(route('api.v1.programs.subjects.index', $program));

    $response->assertSuccessful()
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

test('it returns 404 for non-existent program', function () {
    $response = $this->getJson(route('api.v1.programs.subjects.index', ['programId' => 999]));

    $response->assertNotFound()
        ->assertJson([
            'status' => 'error',
            'error' => true,
            'message' => 'Program not found',
        ]);
});

test('it only returns subjects associated with the specified program', function () {
    $university = University::factory()->create();
    $program1 = Program::factory()->create();
    $program2 = Program::factory()->create();

    $subject1 = Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program1->id,
    ]);
    $subject2 = Subject::factory()->create([
        'university_id' => $university->id,
        'program_id' => $program2->id,
    ]);

    $response = $this->getJson(route('api.v1.programs.subjects.index', $program1));

    $response->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['subject_id' => $subject1->id])
        ->assertJsonMissing(['subject_id' => $subject2->id]);
});
