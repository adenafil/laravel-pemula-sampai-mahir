<?php

namespace App\Services;

interface TodolstService
{
    public function saveTodo(string $id, string $todo): void;
}
