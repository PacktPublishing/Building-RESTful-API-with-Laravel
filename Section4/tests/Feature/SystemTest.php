<?php

namespace Tests\Feature;

use Tests\TestCase;

class SystemTest extends TestCase
{
    public function testName()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testPing()
    {
        $response = $this->get('/api/status/ping');

        $response->assertStatus(200);
    }
}