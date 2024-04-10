<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncludeTest extends TestCase
{
    public function testInclude()
    {
        $this->view('include', [])
            ->assertSeeText('Ade Nafil Firmansah')
            ->assertSeeText('Selamat Datang di Website Kami')
            ->assertSeeText('Selamat Datang di Web');

        $this->view('include', [
            'title' => 'Masuk Pak Eko'
        ])
            ->assertSeeText('Masuk Pak Eko')
            ->assertSeeText('Selamat Datang di Website Kami')
            ->assertSeeText('Selamat Datang di Web');
    }
}
