<?php

namespace App\services;

class SayHello
{
    public function sayHello(string $name): string
    {
        return "Hello $name";
    }
}
