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

    public function testStringRepresentation()
    {
        $collection = collect(['ade', 'nafil', 'firmansah']);

        assertEqualsCanonicalizing('ade-nafil-firmansah', $collection->join('-'));
        assertEqualsCanonicalizing('ade-nafil_firmansah', $collection->join('-', '_'));
        assertEqualsCanonicalizing('ade, nafil and firmansah', $collection->join(', ', ' and '));
        assertEqualsCanonicalizing('ade.nafil@firmansah', $collection->join('.', '@'));

    }

    public function testFilter()
    {
        $collection = collect([
            'ade' => 100,
            'nafil' => 80,
            'firmansah' => '90'
        ]);

        $result = $collection->filter(function ($value, $key) {
            return $value >= 90;
        });

        assertEquals([
            'ade' => 100,
            'firmansah' => 90,
        ], $result->all());

    }

    public function testFilterIndex()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
        $result = $collection->filter(function ($value, $key) {
            return ($value % 2) == 0;
        });

        assertEqualsCanonicalizing([2, 4, 6, 8, 10], $result->all());
        assertEquals([
            1 => 2,
            3 => 4,
            5 => 6,
            7 => 8,
            9 => 10,
        ], $result->all());

    }

    public function testPartitioning()
    {
        $collection = collect([
            'ade' => 100,
            'nafil' => 80,
            'firmansah' => '90'
        ]);

        // array destructing
        [$result1, $result2] = $collection->partition(function ($value, $key) {
            return $value >= 90;
        });

        assertEquals([
            'ade' => 100,
            'firmansah' => 90,
        ], $result1->all());

        assertEquals([
            'nafil' => 80,
        ], $result2->all());
    }

    public function testPartitioning1()
    {
        $collection = collect([
            'ade' => 100,
            'nafil' => 80,
            'firmansah' => '90'
        ]);

        $result = $collection->partition(function ($value, $key) {
            return $value >= 90;
        });

        assertEquals([
            'ade' => 100,
            'firmansah' => 90,
        ], $result[0]->all());

        assertEquals([
            'nafil' => 80,
        ], $result[1]->all());
    }

    public function testTesting()
    {
        $collection = collect(['ade', 'nafil', 'firmansah']);

        self::assertTrue($collection->contains('ade'));
        self::assertTrue($collection->contains(function ($value, $key) {
            return $value == 'ade';
        }));
    }

    public function testGrouping()
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

        $result = $collection->groupBy('department');

        self::assertEquals([
            'it' => collect(
                [
                    [
                        'name' => 'ade',
                        'department' => 'it'
                    ],
                    [
                        'name' => 'nafil',
                        'department' => 'it'
                    ],
                ],
            ),
            'hr' => collect(
                [
                    [
                        'name' => 'firmansah',
                        'department' => 'hr'
                    ],
                ]
            )
        ], $result->all());

        $result = $collection->groupBy(function ($value, $key) {
            return strtoupper($value['department']);
        });

        self::assertEquals([
            'IT' => collect(
                [
                    [
                        'name' => 'ade',
                        'department' => 'it'
                    ],
                    [
                        'name' => 'nafil',
                        'department' => 'it'
                    ],
                ],
            ),
            'HR' => collect(
                [
                    [
                        'name' => 'firmansah',
                        'department' => 'hr'
                    ],
                ]
            )
        ], $result->all());

    }

    public function testSlice()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

        $result = $collection->slice(3);
        assertEquals([
            3 => 4,
            4 => 5,
            5 => 6,
            6 => 7,
            7 => 8,
            8 => 9,
        ], $result->all());

        assertEqualsCanonicalizing([4, 5, 6, 7, 8, 9], $result->all());

        $result = $collection->slice(3, 2);
        assertEquals([
            3 => 4,
            4 => 5,
        ], $result->all());
        assertEqualsCanonicalizing([4, 5], $result->all());
    }

    public function testTake()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

        $result = $collection->take(3);

        assertEqualsCanonicalizing([1, 2, 3], $result->all());

        $result = $collection->takeUntil(function ($value, $key) {
            return $value == 3;
        });

        assertEqualsCanonicalizing([1, 2], $result->all());

        $result = $collection->takeWhile(function ($value, $key) {
            return $value < 3;
        });

        assertEqualsCanonicalizing([1, 2], $result->all());

    }

    public function testSkip()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

        $result = $collection->skip(3);

        assertEqualsCanonicalizing([4, 5, 6, 7, 8, 9], $result->all());

        $result = $collection->skipUntil(function ($value, $key) {
            return $value == 3;
        });

        assertEqualsCanonicalizing([3, 4, 5, 6, 7, 8, 9], $result->all());

        $result = $collection->skipWhile(function ($value, $key) {
            return $value < 3;
        });

        assertEqualsCanonicalizing([3, 4, 5, 6, 7, 8, 9], $result->all());

    }
}
