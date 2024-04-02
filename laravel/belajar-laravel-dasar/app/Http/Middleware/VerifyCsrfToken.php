<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
        "http://localhost:8000/input/hello",
        "http://localhost:8000/input/hello/first",
        "http://localhost:8000/input/hello/input",
        "http://localhost:8000/input/hello/array",
        'http://localhost:8000/input/type',
    ];
}
