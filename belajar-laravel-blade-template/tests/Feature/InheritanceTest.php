<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InheritanceTest extends TestCase
{
    public function testInheritance()
    {
        $this->view('child', [])
            ->assertSeeText('Nama Aplikasi - Halaman Utama')
            ->assertSeeText('Default Header')
            ->assertDontSee('Default Content')
            ->assertSeeText('Deskripsi Header')
            ->assertSeeText('Ini adalah halaman utama');
    }

    public function testInheritanceWithoutOverride()
    {
        $this->view('child-default', [])
            ->assertSeeText('Nama Aplikasi - Halaman Utama')
            ->assertSeeText('Default Header')
            ->assertSeeText('Default Content')
            ->assertDontSee('Deskripsi Header')
            ->assertDontSee('Ini adalah halaman utama');
    }
}
