<?php

use App\Models\Program;
use App\Models\University;

test('it returns empty list when university has no programs', function () {
    $university = University::factory()->create();

    $response = $this->getJson("/api/v1/universities/{$university->id}/programs");

    $response->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(0, 'data');
});

test('it can list programs for a university', function () {
    $university = University::factory()->create();
    $program = Program::factory()->create();
    $university->programs()->attach($program);

    $response = $this->getJson("/api/v1/universities/{$university->id}/programs");

    $response->assertSuccessful()
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

test('it returns 404 for non-existent university', function () {
    $response = $this->getJson('/api/v1/universities/999/programs');

    $response->assertNotFound()
        ->assertJson([
            'status' => 'error',
            'error' => true,
            'message' => 'University not found',
        ]);
});

test('it only returns programs associated with the specified university', function () {
    $university1 = University::factory()->create();
    $university2 = University::factory()->create();

    $program1 = Program::factory()->create();
    $program2 = Program::factory()->create();

    $university1->programs()->attach($program1);
    $university2->programs()->attach($program2);

    $response = $this->getJson("/api/v1/universities/{$university1->id}/programs");

    $response->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['program_id' => $program1->id])
        ->assertJsonMissing(['program_id' => $program2->id]);
});
