<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView()
    {
        $this->get('/hello')
            ->assertSeeText('Hello ade');

        $this->get('/hello-again')
            ->assertSeeText('Hello nafil');
    }

    public function testNested()
    {
        $this->get('/hello-world')
            ->assertSeeText('World nafil');
    }

    public function testTemplate()
    {
        $this->view('hello', ['name' => 'ade'])
            ->assertSeeText('Hello ade');

        $this->view('hello.world', ['name' => 'ade'])
            ->assertSeeText('World ade');
    }
}
