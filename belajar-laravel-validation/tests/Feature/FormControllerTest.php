<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormControllerTest extends TestCase
{
    public function testLoginFailed()
    {
        $response = $this->post('/form/login', [
            'username' => '',
            'password' => '',
        ]);

        $response->assertStatus(400);
    }

    public function testLoginSuccess()
    {
        $response = $this->post('/form/login', [
            'username' => 'ade',
            'password' => 'ade',
        ]);

        $response->assertStatus(200);

    }
}
