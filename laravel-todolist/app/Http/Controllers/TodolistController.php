<?php

namespace App\Http\Controllers;

use App\Services\TodolstService;
use Illuminate\Http\RedirectResponse;
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

    public function addTodo(Request $request): Response | RedirectResponse
    {
        $todo = $request->input('todo');

        if (empty($todo)) {
            $todolist = $this->todolstService->getTodolist();
            return \response()->view('todolist.todolist', [
                'title' => 'todo',
                'todolist' => $todolist,
                'error' => 'Todo is required',
            ]);
        }

        $this->todolstService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodolistController::class, 'todoList']);
    }

    public function removeTodo(Request $request, string $todoId): RedirectResponse
    {
        $this->todolstService->removeTodo($todoId);
        return redirect()->action([TodolistController::class, 'todoList']);
    }
}
