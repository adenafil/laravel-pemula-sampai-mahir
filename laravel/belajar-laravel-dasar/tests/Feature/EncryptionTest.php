<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class EncryptionTest extends TestCase
{
    public function testEncryption()
    {
        $encrycpt = Crypt::encrypt("Ade Nafil Firmansah");
        $decrycpt = Crypt::decrypt($encrycpt);

        var_dump($encrycpt);

        self::assertEquals("Ade Nafil Firmansah", $decrycpt);
    }
}
