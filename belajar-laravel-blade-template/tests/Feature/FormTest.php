<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormTest extends TestCase
{
    public function testForm()
    {
        $this->view('form', ['user' => [
            'premium' => true,
            'name' => 'ade',
            'admin' => true
        ]])
            ->assertSee('checked')
            ->assertSee('ade')
            ->assertDontSee('readonly');

        $this->view('form', ['user' => [
            'premium' => false,
            'name' => 'ade',
            'admin' => false
        ]])
            ->assertDontSee('checked')
            ->assertSee('ade')
            ->assertSee('readonly');

    }
}
