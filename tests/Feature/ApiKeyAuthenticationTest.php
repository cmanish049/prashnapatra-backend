<?php

test('it rejects requests without api key', function (): void {
    $this->withoutHeader('X-API-Key')
        ->getJson(route('api.v1.universities.index'))
        ->assertUnauthorized()
        ->assertJson([
            'status' => 'error',
            'error' => true,
            'message' => 'Invalid or missing API key',
        ]);
});

test('it rejects requests with invalid api key', function (): void {
    $this->withHeader('X-API-Key', 'invalid-key')
        ->getJson(route('api.v1.universities.index'))
        ->assertUnauthorized()
        ->assertJson([
            'status' => 'error',
            'error' => true,
            'message' => 'Invalid or missing API key',
        ]);
});

test('it accepts requests with valid api key', function (): void {
    $this->withApiKey()
        ->getJson(route('api.v1.universities.index'))
        ->assertSuccessful();
});
