<?php

namespace Tests\Feature;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;

class QueryBuilderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        DB::delete('delete from products');
        DB::delete("delete from categories");
    }

    public function testInsert()
    {

        DB::table('categories')->insert([
            'id' => 'GADGET',
            'name' => 'Gadget'
        ]);

        DB::table('categories')->insert([
            'id' => 'FOOD',
            'name' => 'Food'
        ]);

        $result = DB::select("select count(id) as total from categories");

        self::assertEquals(2, $result[0]->total);

    }

    public function testSelect()
    {
        $this->testInsert();

        $collection = DB::table('categories')->select(['id', 'name'])->get();

        self::assertNotNull($collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function insertCategories()
    {
        DB::table('categories')->insert([
           'id' => 'SMARTPHONE',
           'name' => 'Smartphone',
           'created_at' => '2020-10-10 10:10:10'
        ]);
        DB::table('categories')->insert([
            'id' => 'FOOD',
            'name' => 'Food',
            'created_at' => '2020-10-10 10:10:10'
        ]);
        DB::table('categories')->insert([
            'id' => 'LAPTOP',
            'name' => 'Laptop',
            'created_at' => '2020-10-10 10:10:10'
        ]);
        DB::table('categories')->insert([
            'id' => 'FASHION',
            'name' => 'Fashion',
            'created_at' => '2020-10-10 10:10:10'
        ]);
    }

    public function testGettingWithoutSelect()
    {
        $this->insertCategories();

        $collection = DB::table('categories')
            ->get(['name']);

        var_dump(json_encode($collection));

        self::assertTrue(true);
    }

    public function testWhere()
    {
        $this->insertCategories();

        $collection = DB::table('categories')->where(function (Builder $builder) {
           $builder->where('id', '=', 'SMARTPHONE');
           $builder->orWhere('id', '=', 'LAPTOP');
           // select * from categories where (id = SMARTPHONE OR id = LAPTOP)
        })->get();

        self::assertCount(2, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhereBetween()
    {
        $this->insertCategories();

        $collection = DB::table('categories')
            ->whereBetween('created_at', ['2020-09-10 10:10:10', '2020-11-10 10:10:10'])
            ->get();

        self::assertCount(4, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhereIn()
    {
        $this->insertCategories();

        $collection = DB::table('categories')->whereIn('id', ['SMARTPHONE', "LAPTOP"])->get();

        assertCount(2, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });

    }

    public function testWhereNull()
    {
        $this->insertCategories();

        $collection = DB::table('categories')->whereNull('description')->get();

        self::assertCount(4, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });

    }

    public function testWhereDate()
    {
        $this->insertCategories();

        $collection = DB::table('categories')
            ->whereDate('created_at', '2020-10-10')->get();

        self::assertCount(4, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });

    }

    public function testUpdate()
    {
        $this->insertCategories();

        DB::table('categories')->where('id', '=', 'SMARTPHONE')
            ->update([
               'id' => 'Handphone'
            ]);

        $collection = DB::table('categories')->where('id', '=', 'Handphone')
            ->get();

        self::assertCount(1, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testUpsert()
    {
        DB::table('categories')->updateOrInsert(
            [
                'id' => 'VOUCHER'
            ],
            [
                'name' => 'Voucher',
                'description' => 'Ticket and Voucher',
                'created_at' => '2020-10-10 10:10:10',
            ]
        );

        $collection = DB::table('categories')->where('id', '=', 'VOuCHER')
            ->get();

        self::assertCount(1, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });

    }

    public function testIncrement()
    {
        DB::table('counters')->where('id', '=', 'sample')
            ->increment('counter', 1);

        $collection = DB::table('counters')->where('id','=', 'sample')
            ->get();

        self::assertCount(1, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });

    }

    public function testDelete()
    {
        $this->insertCategories();

        DB::table('categories')->where('id', '=', 'smartphone')
            ->delete();

//        DB::table('categories')->delete('smartphone');

        $collection = DB::table('categories')->where('id', '=', 'name')->get();

        self::assertCount(0, $collection);
    }

    public function insertProudcts()
    {
        $this->insertCategories();

        DB::table('products')
            ->insert(
                [
                    'id' => '1',
                    'name' => 'iPhone 14 Pro Max',
                    'category_id' => "SMARTPHONE",
                    'price' => '20000000'
                ]
            );

        DB::table('products')
            ->insert(
                [
                    'id' => '2',
                    'name' => 'Samsung Galaxy S21 Ultra',
                    'category_id' => "SMARTPHONE",
                    'price' => '18000000'
                ]
            );
    }

    public function testJoin()
    {
        $this->insertProudcts();

        $collection = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.id', 'products.name', 'products.price', 'categories.name as category_name')
            ->get();

        self::assertCount(2, $collection);
        $collection->each(function ($item) {
           Log::info(json_encode($item));
        });
    }

    public function testOrdering()
    {
        $this->insertProudcts();

        $collection = DB::table('products')
            ->whereNotNull('id')
            ->orderBy('price', 'desc')
            ->orderBy('name')
            ->get();

        self::assertCount(2, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });

    }

    public function testPaging()
    {
        $this->insertCategories();

        $collection = DB::table('categories')
            ->skip(2)
            ->take(2)
            ->get('name');

        self::assertCount(2, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });

    }

    public function insertManyCategories()
    {
        for ($i = 0; $i < 100; $i++) {
            DB::table('categories')->insert([
                'id' => "CATEGORY-$i",
                'name' => "Category $i",
                'created_at' => '2020-10-10 10:10:10'
            ]);
        }
    }

    public function testChunk()
    {
        $this->insertManyCategories();

        DB::table('categories')
            ->orderBy('id')
            ->chunk(10, function ($categories) {
                self::assertNotNull($categories);
                Log::info('Start Chunk');
                $categories->each(function ($category) {
                    Log::info(json_encode($category));
                });
                Log::info('End Chunk');
            });
    }

    public function testLazy()
    {
        $this->insertManyCategories();

//        $collection = DB::table('categories')->orderBy('id')
//            ->lazy(10);

        $collection = DB::table('categories')->orderBy('id')
            ->lazy(10)->take(3);

        self::assertNotNull($collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });

    }

    public function testCursor()
    {
        $this->insertManyCategories();

        $collection = DB::table('categories')
        ->orderBy('id')
        ->cursor();

        self::assertNotNull($collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testAggregate()
    {
        $this->insertProudcts();

        $result = DB::table('products')->count();
        assertEquals(2, $result);

        $result = DB::table('products')->min('price');
        assertEquals(18000000, $result);

        $result = DB::table('products')->max('price');
        assertEquals(20000000, $result);

        $result = DB::table('products')->sum('price');
        assertEquals(38000000, $result);

        $result = DB::table('products')->avg('price');
        assertEquals(19000000, $result);

    }

    public function testQueryBuilderRaw()
    {
        $this->insertProudcts();

        $collection = DB::table('products')
            ->select(
              DB::raw('count(id) as total_product'),
              DB::raw('min(price) as min_price'),
              DB::raw('max(price) as max_price'),
            )->get();

        assertEquals(2, $collection[0]->total_product);
        assertEquals(18000000, $collection[0]->min_price);
        assertEquals(20000000, $collection[0]->max_price);
    }

}