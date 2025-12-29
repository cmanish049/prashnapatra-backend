<?php

use App\Models\University;

test('it can fetch empty list of universities', function () {
    $response = $this->getJson('/api/v1/universities');

    $response->assertSuccessful()
        ->assertJsonCount(0, 'data');
});

test('it can list universities', function () {
    /* @var University $university */
    $university = University::factory()->create();

    $response = $this->getJson('/api/v1/universities');

    $response->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment([
            'name' => $university->name,
            'label' => $university->label
        ]);
});
