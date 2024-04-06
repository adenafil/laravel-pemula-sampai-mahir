<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            'user' => 'ade'
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            'user' => 'ade',
            'password' => 'rahasia'
        ])->assertRedirect('/')
            ->assertSessionHas('user', 'ade');
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            'user' => 'ade'
        ])->post('/login', [
            'user' => 'ade',
            'password' => 'rahasia'
        ])->assertRedirect('/');
    }


    public function testLoginValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText('User or password is required');
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => 'bebas',
            'password' => 'lupa'
        ])->assertSeeText('User or Password is wrong');
    }

    public function testLogout()
    {
        $this->withSession([
            'user' => 'ade'
        ])->post('/logout')
            ->assertRedirect('/')
            ->assertSessionMissing('user');
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/');
    }
}
