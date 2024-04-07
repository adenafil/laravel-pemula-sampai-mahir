<?php

namespace App\Services\Impl;

use App\Services\TodolstService;
use Illuminate\Support\Facades\Session;

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
}
