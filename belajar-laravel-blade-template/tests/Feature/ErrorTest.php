<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ErrorTest extends TestCase
{
    public function testError()
    {
        $errors = [
            'name' => 'Name is required',
            'password' => 'Password is required',
        ];

        $this->withViewErrors($errors)
            ->view('error', [])
            ->assertSee('Name is required')
            ->assertSee('Password is required');
    }
}
