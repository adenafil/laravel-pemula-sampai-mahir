<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
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
}
