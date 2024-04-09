<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestResponseController extends TestCase
{
    public function testResponse()
    {
        $this->get('/response/hello')
            ->assertStatus(200)
            ->assertSeeText("Hello response");
    }

    public function testHeader()
    {
        $this->get('/response/header')
            ->assertStatus(200)
            ->assertSeeText('Ade')
            ->assertSeeText("Nafil")
            ->assertHeader('Content-Type', 'application/json')
            ->assertHeader('Author', 'Ade Nafil Firmansah')
            ->assertHeader('App', 'Belajar Laravel');
    }

    public function testView()
    {
        $this->get('/response/type/view')
            ->assertSeeText('Hello Ade');
    }

    public function testJson()
    {
        $this->get('/response/type/json')
            ->assertJson([
               'firstName' => 'Ade',
               'lastName' => 'Nafil',
            ]);
    }

    public function testFile()
    {
        $this->get('/response/type/file')
            ->assertHeader('Content-Type', 'image/png');
    }

    public function testDownload()
    {
        $this->get('/response/type/download')
            ->assertDownload('Screenshot 2024-04-02 135834.png');
    }
}
