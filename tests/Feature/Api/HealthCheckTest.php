<?php

use Illuminate\Support\Facades\DB;

it('returns healthy status when database is connected', function () {
    $this->getJson('/api/health')
        ->assertOk()
        ->assertJson([
            'status' => 'healthy',
            'database' => true,
        ]);
});

it('returns unhealthy status when database is down', function () {
    DB::shouldReceive('connection->getPdo')
        ->andThrow(new RuntimeException('Connection refused'));

    $this->getJson('/api/health')
        ->assertServiceUnavailable()
        ->assertJson([
            'status' => 'unhealthy',
            'database' => false,
        ]);
});
