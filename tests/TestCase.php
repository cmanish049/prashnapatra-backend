<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function withApiKey(): static
    {
        return $this->withHeader('X-API-Key', 'test-api-key');
    }
}
