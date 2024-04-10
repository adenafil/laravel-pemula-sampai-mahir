<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WhileTest extends TestCase
{
    public function testWhile()
    {
        $this->view('while', ['i' => 0])
            ->assertSeeText('the current value is 0')
            ->assertSeeText('the current value is 1')
            ->assertSeeText('the current value is 2')
            ->assertSeeText('the current value is 3')
            ->assertSeeText('the current value is 4')
            ->assertSeeText('the current value is 5')
            ->assertSeeText('the current value is 7')
            ->assertSeeText('the current value is 8')
            ->assertSeeText('the current value is 9');
    }
}
