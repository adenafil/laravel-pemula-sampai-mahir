<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloTest extends TestCase
{
    public function testHello()
    {
        $this->get('/hello')
            ->assertSeeText('ade');
    }

    public function testWorld()
    {
        $this->get('/world')
            ->assertSeeText('ade');
    }

    public function testHelloView()
    {
        $this->view('hello', ['name' => 'ade'])
            ->assertSeeText('ade');
    }

    public function testWorldView()
    {
        $this->view('hello.world', ['name' => 'ade'])
            ->assertSeeText('ade');
    }

}
