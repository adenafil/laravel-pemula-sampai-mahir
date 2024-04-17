<?php

namespace Tests\Feature;

use App\Data\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertEqualsCanonicalizing;

class CollectionTest extends TestCase
{
    public function testCreateCollection()
    {
        $collection = collect([1, 2, 3]);
        self::assertEqualsCanonicalizing([1, 2, 3], $collection->all());
    }

    public function testForEach()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        foreach ($collection as $key => $value) {
            assertEquals($key + 1, $value);
        }
    }

    public function testCrud()
    {
        $collection = collect([]);
        $collection->push(1, 2, 3);
        $this->assertEqualsCanonicalizing([1, 2, 3], $collection->all());

        $result = $collection->pop();
        assertEquals(3, $result);
        $this->assertEqualsCanonicalizing([1, 2], $collection->all());
    }

    public function testMap()
    {
        $collection = collect([1, 2, 3]);
        $result = $collection->map(function ($item) {
            return $item * 2;
        });

        assertEqualsCanonicalizing([2, 4, 6], $result->all());
    }

    public function testMapInto()
    {
        $collection = collect(['ade']);
        $result = $collection->mapInto(Person::class);
        assertEquals([new Person('ade')], $result->all());
    }

    public function testMapSpread()
    {
        $collection = collect([
            ['ade', 'nafil'],
            ['nafil', 'firmansah']
        ]);

        $result = $collection->mapSpread(function ($firstName, $lastName) {
            $fullName = $firstName . ' ' . $lastName;
            return new Person($fullName);
        });

        assertEquals([
            new Person('ade nafil'),
            new Person('nafil firmansah'),
        ], $result->all());
    }

    public function testMapToGroup()
    {
        $collection = collect([
           [
               'name' => 'ade',
               'department' => 'it'
           ],
            [
                'name' => 'nafil',
                'department' => 'it'
            ],
            [
                'name' => 'firmansah',
                'department' => 'hr'
            ],
        ]);

        $result = $collection->mapToGroups(function ($person) {
           return [
               $person['department'] => $person['name']
           ];
        });

        assertEquals([
            'it' => collect(['ade', 'nafil']),
            'hr' => collect(['firmansah']),
        ], $result->all());
    }

    public function testZip()
    {
        $collection1 = collect([1, 2, 3]);
        $collection2 = collect([4, 5, 6]);
        $collection3 = $collection1->zip($collection2);

        assertEquals([
            collect([1, 4]),
            collect([2, 5]),
            collect([3, 6]),
        ], $collection3->all());
    }

    public function testConcat()
    {
        $collection1 = collect([1, 2, 3]);
        $collection2 = collect([4, 5, 6]);
        $collection3 = $collection1->concat($collection2);

        assertEqualsCanonicalizing([1, 2, 3, 4, 5, 6], $collection3->all());
    }

    public function testCombine()
    {
        $collection1 = collect(['name', 'country']);
        $collection2 = collect(['ade', 'indonesia']);
        $collection3 = $collection1->combine($collection2);

        assertEqualsCanonicalizing([
            'name' => 'ade',
            'country' => 'indonesia'
        ], $collection3->all());
    }

    public function testCollapse()
    {
        $collection = collect([
           [1, 2, 3],
           [4, 5, 6],
           [7, 8, 9],
        ]);

        $result = $collection->collapse();

        assertEqualsCanonicalizing([1, 2, 3, 4, 5, 6, 7, 8, 9], $result->all());
    }

    public function testFlatMap()
    {
        $collection = collect([
            [
                'name' => 'ade',
                'hobbies' => ['makan', 'minum']
            ],
            [
                'name' => 'nafil',
                'hobbies' => ['coding', 'reading']
            ],
        ]);

        $result = $collection->flatMap(function ($data) {
            return $data['hobbies'];
        });

        assertEqualsCanonicalizing(['makan', 'minum', 'coding', 'reading'],
            $result->all()
        );

    }
}
