<?php

namespace App\Services\Impl;

use App\Services\TodolstService;
use Illuminate\Support\Facades\Session;
use function PHPUnit\Framework\assertTrue;

class TodolistServiceImpl implements TodolstService
{
    public function saveTodo(string $id, string $todo): void
    {
       if (!Session::exists('todolist')) {
           Session::put('todolist', []);
       }

       Session::push('todolist', [
           'id' => $id,
           'todo' => $todo,
       ]);
    }


    public function getTodolist(): array
    {
        return Session::get('todolist', []);
    }

    public function removeTodo(string $id)
    {
        $todolist = Session::get('todolist');

        foreach ($todolist as $index => $value) {
            if ($value['id'] == $id) {
                unset($todolist[$index]);
                break;
            }
        }

        Session::put('todolist', $todolist);
    }
}
