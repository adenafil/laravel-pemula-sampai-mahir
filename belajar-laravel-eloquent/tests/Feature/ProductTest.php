<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use function Laravel\Prompts\select;
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

    public function testOneToOnePolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class ,ImageSeeder::class]);

        $product = Product::find('1');
        assertNotNull($product);

        $image = $product->image;
        assertNotNull($image);

        assertEquals('https://www.programmerzamannow.com/image/2.jpg', $image->url);
    }

    public function testOneToManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class ,VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::find('1');
        assertNotNull($product);

        $comments = $product->comments;
        foreach ($comments as $comment) {
            self::assertEquals('product', $comment->commentable_type);
            self::assertEquals($product->id, $comment->commentable_id);
        }
    }

    public function testOneOfManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class ,VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::find('1');
        assertNotNull($product);

        $comment = $product->latestComment;
        self::assertNotNull($comment);
        var_dump($comment->id);

        $comment = $product->oldestComment;
        self::assertNotNull($comment);
        var_dump($comment->id);

    }

    public function testManyToManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class ,VoucherSeeder::class, TagSeeder::class]);

        $product = Product::find('1');
        $tags = $product->tags;
        self::assertNotNull($tags);
        self::assertCount(1, $tags);


        foreach ($tags as $tag) {
            self::assertNotNull($tag->id);
            self::assertNotNull($tag->name);

            $vouchers = $tag->vouchers;


            self::assertNotNull($vouchers);
            self::assertCount(1, $vouchers);
        }
    }

    public function testEloquentCollection()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        // 2 Products, 1, 2
        $products = Product::get();

        // where id in (1, 2);
        $products = $products->toQuery()->where('price', 200)->get();

        self::assertNotNull($products);
        self::assertEquals(2, $products[0]->id);

    }

    public function testSerialization()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $products = Product::query()->get();
        self::assertCount(2, $products);

        $json = $products->toJson(JSON_PRETTY_PRINT);
        Log::info($json);
    }

    public function testSerializationRelation()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);

        $products = Product::query()->get();
        $products->load(['category', 'image']);
        self::assertCount(2, $products);

        $json = $products->toJson(JSON_PRETTY_PRINT);
        Log::info($json);
    }

}
