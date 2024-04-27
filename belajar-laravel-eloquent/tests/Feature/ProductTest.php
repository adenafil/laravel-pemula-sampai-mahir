<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class ProductTest extends TestCase
{
    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::query()->find(1);
        assertNotNull($product);

        $category = $product->category;
        assertNotNull($category);
        assertEquals('FOOD', $category->id);

        $total = $category->count();
        assertEquals(1, $total);
    }

    public function testHasOneOfMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find('FOOD');
        assertNotNull($category);

        $cheapestProduct = $category->cheapestProduct;
        assertNotNull($cheapestProduct);
        assertEquals(1, $cheapestProduct->id);

        $mostExpensiveProduct = $category->mostExpensiveProduct;
        assertNotNull($mostExpensiveProduct);
        assertEquals(2, $mostExpensiveProduct->id);


    }
}
