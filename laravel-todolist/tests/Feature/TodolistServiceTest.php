<?php

namespace Tests\Feature;

use App\Services\TodolstService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use MongoDB\Driver\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolstService $todolstService;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->todolstService = $this->app->make(TodolstService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolstService);
    }

    public function testSaveTodo()
    {
        $this->todolstService->saveTodo('1', 'ade');

        $todolist = \Illuminate\Support\Facades\Session::get('todolist');

        foreach ($todolist as $value) {
            self::assertEquals('1', $value['id']);
            self::assertEquals('ade', $value['todo']);
        }
    }

    public function testGetTodolistEmpty()
    {
        self::assertEquals([], $this->todolstService->getTodolist());
    }

    public function testGetTodolistNotEmpty()
    {
        $expected = [
            [
                'id' => '1',
                'todo' => 'ade',
            ],
            [
                'id' => '2',
                'todo' => 'firmansah',
            ],
        ];

        $this->todolstService->saveTodo('1', 'ade');
        $this->todolstService->saveTodo('2', 'firmansah');

        self::assertEquals($expected, $this->todolstService->getTodolist());
    }

    public function testRemoveTodo()
    {
        $this->todolstService->saveTodo('1', 'ade');
        $this->todolstService->saveTodo('2', 'firmansah');

        self::assertEquals(2, sizeof($this->todolstService->getTodolist()));

        $this->todolstService->removeTodo('3');

        self::assertEquals(2, sizeof($this->todolstService->getTodolist()));

        $this->todolstService->removeTodo('1');

        self::assertEquals(1, sizeof($this->todolstService->getTodolist()));

        $this->todolstService->removeTodo('2');

        self::assertEquals(0, sizeof($this->todolstService->getTodolist()));
    }
}