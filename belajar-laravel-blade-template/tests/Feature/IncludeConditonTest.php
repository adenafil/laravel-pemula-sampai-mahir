<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncludeConditonTest extends TestCase
{
    public function testIncludeCondition()
    {
        $this->view('include-condition', [
            'user' => [
                'name' => 'ade',
                'owner' => true
            ]
        ])->assertSeeText('Selamat Datang Owner')
            ->assertSeeText('Selamat Datang ade');

        $this->view('include-condition', [
            'user' => [
                'name' => 'ade',
                'owner' => false
            ]
        ])->assertDontSeeText('Selamat Datang Owner')
            ->assertSeeText('Selamat Datang ade');

    }
}
