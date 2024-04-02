<?php

namespace Tests\Feature;

use http\Env\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=ade')
            ->assertSeeText("Hello ade");

        $this->post('/input/name', [
            "name" => 'ade'
        ])->assertSeeText("Hello ade");
    }

    public function testInputNested()
    {
        $this->post('/input/hello/first', [
            'name' => [
                "first" => "ade"
            ]
        ])->assertSeeText("Hello ade");
    }

    public function testAll()
    {
        $this->post('/input/hello/input', [
            'name' => [
                "first" => "ade",
                "middle" => "nafil",
                "last" => "firmansah",
            ]
        ])->assertSeeText("name")
        ->assertSeeText("first")
        ->assertSeeText("last")
        ->assertSeeText("ade")
        ->assertSeeText("nafil")
        ->assertSeeText("firmansah");
    }

    public function testInputArray()
    {
        $this->post('/input/hello/array', [
            'products' => [
                [
                    'name' => 'Xiaomi 14',
                    'price' => '10.999.999'
                ],
                [
                    'name' => 'Xiaomi 14 Pro',
                    'price' => '13.999.999'
                ]
            ]
        ])->assertSeeText('Xiaomi 14')
        ->assertSeeText("Xiaomi 14 Pro");
    }
}
