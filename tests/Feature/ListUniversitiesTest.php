<?php

use App\Models\University;

test('it can fetch empty list of universities', function () {
    $response = $this->getJson('/api/v1/universities');

    $response->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(0, 'data');
});

test('it can list universities', function () {
    $university = University::factory()->create();

    $response = $this->getJson('/api/v1/universities');

    $response->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment([
            'university_id' => $university->id,
            'name' => $university->name,
            'label' => $university->label,
        ]);
});
