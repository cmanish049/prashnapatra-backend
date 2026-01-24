<?php

use App\Models\University;

test('it can fetch empty list of universities', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.universities.index'))
        ->assertSuccessful()
        ->assertJson([
            'status' => 'success',
            'error' => false,
        ])
        ->assertJsonCount(0, 'data');
});

test('it can list universities', function (): void {
    $university = University::factory()->create();

    $this->withApiKey()
        ->getJson(route('api.v1.universities.index'))
        ->assertSuccessful()
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
