<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet()
    {
        $this->get('/ade')
            ->assertStatus(200)
            ->assertSeeText('Hello Ade Nafil Firmansah');
    }

    public function testRedirect()
    {
        $this->get('youtube')
            ->assertRedirect('/ade');
    }

    public function testFallback()
    {
        $this->get('/adebayor')
            ->assertSeeText('ade');

        $this->get('/ups')
            ->assertSeeText('ade');
    }

    public function testRouteParameter()
    {
        $this->get('/products/1')
            ->assertSeeText('Product 1');

        $this->get('/products/2')
            ->assertSeeText('Product 2');

        $this->get('/products/1/items/xxx')
            ->assertSeeText('Product 1, item xxx');

        $this->get('/products/2/items/xyx')
            ->assertSeeText('Product 2, item xyx');
    }

    public function testRouteParameterRegex()
    {
        $this->get('/categories/100')
            ->assertSeeText('Category 100');

        $this->get('/categories/ade')
            ->assertSeeText("404 by ade");
    }

    public function testRouteParameterOptional()
    {
        $this->get('/users/ade')
            ->assertSeeText('User ade');

        $this->get('/users/')
            ->assertSeeText('User not found');
    }

    public function testRouteConflict()
    {
        $this->get('/conflict/budi')
            ->assertSeeText('Conflict budi');

        $this->get('/conflict/ade')
            ->assertSeeText('Conflict ade ]]]');
    }

    public function testNamedRoute()
    {
        $this->get('/produk/12345')
            ->assertSeeText('Link http://localhost/products/12345');

        $this->get('/produk-redirect/12345')
            ->assertRedirect('/products/12345');
    }
}
