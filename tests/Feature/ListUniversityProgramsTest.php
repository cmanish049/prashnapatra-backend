<?php

use App\Models\Program;
use App\Models\University;

test('it returns empty list when university has no programs', function (): void {
    $university = University::factory()->create();

    $this->withApiKey()
        ->getJson(route('api.v1.universities.programs.index', $university))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(0, 'data');
});

test('it can list programs for a university', function (): void {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    $university->programs()->attach($program);

    $this->withApiKey()
        ->getJson(route('api.v1.universities.programs.index', $university))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment([
            'program_id' => $program->id,
            'name' => $program->name,
            'abbreviation' => $program->abbreviation,
        ]);
});

test('it returns 404 for non-existent university', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.universities.programs.index', ['universityId' => 999]))
        ->assertNotFound()
        ->assertJson([
            'status' => 'error',
            'error' => true,
            'message' => 'University not found',
        ]);
});

test('it only returns programs associated with the specified university', function (): void {
    $university1 = University::factory()->create();
    $university2 = University::factory()->create();

    $program1 = Program::factory()->create();
    $program2 = Program::factory()->create();

    $university1->programs()->attach($program1);
    $university2->programs()->attach($program2);

    $this->withApiKey()
        ->getJson(route('api.v1.universities.programs.index', $university1))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['program_id' => $program1->id])
        ->assertJsonMissing(['program_id' => $program2->id]);
});
