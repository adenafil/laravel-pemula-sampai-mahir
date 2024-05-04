<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReviewSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertTrue;

class CategoryTest extends TestCase
{
    public function testInsert()
    {
        $category = new Category();
        $category->id = 'GADGET';
        $category->name = 'Gadget';
        $result = $category->save();

        self::assertTrue($result);
    }

    public function testInsertMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                'id' => "ID $i",
                'name' => "Name $i",
            ];
        }

        $result = Category::query()->insert($categories);

        self::assertTrue($result);

        $total = Category::query()->count();
        self::assertEquals(10, $total);
    }

    public function testFind()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->find('FOOD');

        self::assertNotNull($category);
        self::assertEquals('FOOD', $category->id);
        self::assertEquals('Food', $category->name);
        self::assertEquals('Food Category', $category->description);
    }

    public function testUpdate()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->find('FOOD');

        $category->name = 'Food Updated';

        $result = $category->update();

        assertTrue($result);
    }

    public function testSelect()
    {
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->id = "ID $i";
            $category->name = "Name $i";
            $category->save();
        }

        $result = Category::query()->whereNull('description')->get();

        assertEquals(5, $result->count());

        $result->each(function ($category) {
            self::assertNull($category->description);

            $category->description = 'updated';
            $category->update();
        });
    }

    public function testUpdateMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                'id' => "ID $i",
                'name' => "Name $i",
            ];
        }

        $result = Category::query()->insert($categories);
        self::assertTrue($result);

        Category::query()->whereNull('description')->update([
            'description' => 'updated'
        ]);

        $total = Category::query()->where('description', '=', 'updated')->count();
        self::assertEquals(10, $total);

    }

    public function testDelete()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->find('FOOD');
        $result = $category->delete();
        self::assertTrue($result);

        $total = Category::query()->count();
        assertEquals(0, $total);
    }

    public function testDeleteMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                'id' => "ID $i",
                'name' => "Name $i",
            ];
        }

        $result = Category::query()->insert($categories);
        self::assertTrue($result);

        $total = Category::query()->count();
        self::assertEquals(10, $total);

        Category::query()->whereNull('description')->delete();

        $total = Category::query()->count();
        self::assertEquals(0, $total);

    }

    public function testCreate()
    {
        $request = [
            'id' => 'FOOD',
            'name' => 'Food',
            'description' => 'Food Category',
        ];

        $category = new Category($request);
        $category->save();

        self::assertNotNull($category->id);
    }

    public function testCreateUsingQueryBuilder()
    {
        $request = [
            'id' => 'FOOD',
            'name' => 'Food',
            'description' => 'Food Category',
        ];

        $category = Category::query()->create($request);

        self::assertNotNull($category->id);
    }

    public function testUpdateMass()
    {
        $this->seed(CategorySeeder::class);

        $request = [
            'name' => 'Food Updated',
            'description' => 'Food Category Updated',
        ];

        $category = Category::query()->find('FOOD');
        $category->fill($request);
        $category->save();

        assertNotNull($category->id);
    }

    public function testGlobalScope()
    {
        $category = new Category();
        $category->id = 'FOOD';
        $category->name = 'Food';
        $category->description = 'Food Category';
        $category->is_active = false;
        $category->save();

        $category = Category::query()->find('FOOD');
        self::assertNull($category);

        $category = Category::query()->withoutGlobalScope(IsActiveScope::class)->find('FOOD');
        self::assertNotNull($category);

    }

    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::query()->find('FOOD');
        self::assertNotNull($category);

        $products = $category->products;
        self::assertNotNull($products);

        $total = $products->count();
        assertEquals(1, $total);
    }

    public function testOneToManyQuery()
    {
        $category = new Category();
        $category->id = 'FOOD';
        $category->name = 'Food';
        $category->description = 'Food Category';
        $category->is_active = true;
        $category->save();

        $product = new Product();
        $product->id = '1';
        $product->name = 'Product 1';
        $product->description = 'Description 1';

        $category->products()->save($product);

        self::assertNotNull($product->category_id);
    }

    public function testOneToManyQueryWithSeeder()
    {
        $this->seed(CategorySeeder::class);
        $category = Category::query()->find('FOOD');

        $product = new Product();
        $product->id = '1';
        $product->name = 'Product 1';
        $product->description = 'Description 1';

        $category->products()->save($product);

        self::assertNotNull($product->category_id);
    }

    public function testRelationshipQuery()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::query()->find('FOOD');
        $products = $category->products;
        self::assertCount(1, $products);

        $outOfStockProducts = $category->products()->where('stock', '<=', '0')->get();
        self::assertCount(1, $outOfStockProducts);
        var_dump($outOfStockProducts[0]->description);

    }

    public function testHasManyThrough()
    {
        $this->seed([
            CategorySeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
            ReviewSeeder::class
        ]);

        $category = Category::query()->find('FOOD');
        self::assertNotNull($category);

        $reviews = $category->reviews;
        assertNotNull($reviews);
        self::assertCount(2, $reviews);

    }

    public function testQueryingRelations()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find('FOOD');
        $products = $category->products()->where('price', 200)->get();

        self::assertCount(1, $products);
        assertEquals(2, $products[0]->id);
    }

    public function testQueryingRelationsAggregate()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find('FOOD');
        $total = $category->products()->where('price', 200)->count();

        self::assertEquals(1, $total);


    }

}
