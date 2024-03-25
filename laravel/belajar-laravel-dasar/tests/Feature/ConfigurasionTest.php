<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurasionTest extends TestCase
{
    public function testConfig()
    {
        $firstName = config("contoh.author.first");
        $lastName = config("contoh.author.last");
        $email = config("contoh.email");
        $web = config("contoh.web");

        self::assertEquals("Ade", $firstName);
        self::assertEquals("Firmansah", $lastName);
        self::assertEquals("nafilie9@gmail.com", $email);
        self::assertEquals("https://nafil.dev", $web);
    }
}
