<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoopVariableTest extends TestCase
{
    public function testLoopVariable()
    {
        $this->view('loopvariable', [
            'hobbies' => [
                'coding',
                'gaming',
            ]
        ])
            ->assertSeeText('1. coding')
            ->assertSeeText('2. gaming');
    }
}
