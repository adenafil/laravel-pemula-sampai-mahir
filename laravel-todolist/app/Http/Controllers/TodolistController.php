<?php

namespace App\Http\Controllers;

use App\Services\TodolstService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodolistController extends Controller
{
    private TodolstService $todolstService;

    public function __construct(TodolstService $todolstService)
    {
        $this->todolstService = $todolstService;
    }

    public function todoList(Request $request): Response
    {
        $todolist = $this->todolstService->getTodolist();

        return \response()->view('todolist.todolist', [
            'title' => 'Todolist',
            'todolist' => $todolist
        ]);
    }

    public function addTodo(Request $request)
    {

    }

    public function removeTodo(Request $request, string $todoId)
    {

    }
}
