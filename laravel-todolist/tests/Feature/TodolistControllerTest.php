<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            'user' => 'ade',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'ade',
                ],
                [
                    'id' => '2',
                    'todo' => 'nafil',
                ],
            ]
        ])->get('/todolist')
            ->assertSeeText('1')
            ->assertSeeText('ade')
            ->assertSeeText('2')
            ->assertSeeText('nafil');
    }
}
