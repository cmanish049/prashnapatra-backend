<?php

use App\Models\University;

test('it allows requests within rate limit', function (): void {
    University::factory()->create();

    for ($i = 0; $i < 5; $i++) {
        $this->withApiKey()
            ->getJson(route('api.v1.universities.index'))
            ->assertSuccessful();
    }
});

test('it blocks requests exceeding rate limit', function (): void {
    University::factory()->create();

    // Make 60 requests (the limit)
    for ($i = 0; $i < 60; $i++) {
        $this->withApiKey()
            ->getJson(route('api.v1.universities.index'));
    }

    // 61st request should be rate limited
    $this->withApiKey()
        ->getJson(route('api.v1.universities.index'))
        ->assertStatus(429)
        ->assertJson([
            'status' => 'error',
            'error' => true,
            'message' => 'Too many requests. Please try again later.',
        ])
        ->assertHeader('X-RateLimit-Limit', '60')
        ->assertHeader('X-RateLimit-Remaining', '0');
});

test('it includes rate limit headers in successful responses', function (): void {
    University::factory()->create();

    $this->withApiKey()
        ->getJson(route('api.v1.universities.index'))
        ->assertSuccessful()
        ->assertHeader('X-RateLimit-Limit', '60')
        ->assertHeader('X-RateLimit-Remaining');
});

test('it tracks rate limit by api key', function (): void {
    University::factory()->create();

    // Make 60 requests with first API key
    for ($i = 0; $i < 60; $i++) {
        $this->withApiKey()
            ->getJson(route('api.v1.universities.index'));
    }

    // 61st request with same API key should be blocked
    $this->withApiKey()
        ->getJson(route('api.v1.universities.index'))
        ->assertStatus(429)
        ->assertJson([
            'status' => 'error',
            'error' => true,
        ]);

    // Request with different API key should work
    config(['prasnapatra.api_key' => 'different-key']);
    $this->withHeader('X-API-Key', 'different-key')
        ->getJson(route('api.v1.universities.index'))
        ->assertSuccessful();
});

test('it resets rate limit after one minute', function (): void {
    University::factory()->create();

    // Make 60 requests
    for ($i = 0; $i < 60; $i++) {
        $this->withApiKey()
            ->getJson(route('api.v1.universities.index'));
    }

    // Should be rate limited
    $this->withApiKey()
        ->getJson(route('api.v1.universities.index'))
        ->assertStatus(429)
        ->assertJson([
            'status' => 'error',
            'error' => true,
        ]);

    // Travel forward in time by 61 seconds
    $this->travel(61)->seconds();

    // Should work again
    $this->withApiKey()
        ->getJson(route('api.v1.universities.index'))
        ->assertSuccessful();
});
