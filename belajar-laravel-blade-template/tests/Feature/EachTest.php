<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EachTest extends TestCase
{
    public function testEach()
    {
        $this->view('each', ['users' => [
            [
                'name' => 'ade',
                'hobbies' => [
                    'coding',
                    'gaming',
                ]
            ],
            [
                'name' => 'nafil',
                'hobbies' => [
                    'coding',
                    'gaming',
                ]
            ]
        ]])
            ->assertSeeInOrder([
                'red',
                'ade',
                'coding',
                'gaming',
                'nafil',
                'coding',
                'gaming',
            ]);
    }
}
