<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContohMiddlewareTest extends TestCase
{
    public function testInvalidMidlleware()
    {
        $this->get('middleware/api')
            ->assertStatus(401)
            ->assertSeeText('Access Denied');
    }

    public function testMidllewareValid()
    {
        $this->withHeader('X-API-KEY', 'PZN')
        ->get('middleware/api')
            ->assertStatus(200)
            ->assertSeeText('OK');
    }

    public function testInvalidMidllewareGroup()
    {
        $this->get('middleware/group')
            ->assertStatus(401)
            ->assertSeeText('Access Denied');
    }

    public function testValidMidllewareGroup()
    {
        $this->withHeader('X-API-KEY', 'PZN')
            ->get('middleware/group')
            ->assertStatus(200)
            ->assertSeeText('GROUP');
    }
}
