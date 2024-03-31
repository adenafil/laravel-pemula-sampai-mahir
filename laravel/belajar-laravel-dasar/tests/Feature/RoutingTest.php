<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet()
    {
        $this->get('/ade')
            ->assertStatus(200)
            ->assertSeeText('Hello Ade Nafil Firmansah');
    }

    public function testRedirect()
    {
        $this->get('youtube')
            ->assertRedirect('/ade');
    }

    public function testFallback()
    {
        $this->get('/adebayor')
            ->assertSeeText('ade');

        $this->get('/ups')
            ->assertSeeText('ade');
    }
}
