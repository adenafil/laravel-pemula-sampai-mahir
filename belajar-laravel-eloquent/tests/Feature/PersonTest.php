<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class PersonTest extends TestCase
{
    public function testPerson()
    {
        $person = new Person();

        $person->first_name = 'ade';
        $person->last_name = 'nafil';
        $person->save();

        assertEquals('ADE nafil', $person->full_name);

        $person->full_name = 'nafil firmansah';
        $person->save();

        assertEquals('NAFIL firmansah', $person->full_name);
        assertEquals('NAFIL', $person->first_name);
        assertEquals('firmansah', $person->last_name);
    }

    public function testAttributeCasting()
    {
        $person = new Person();

        $person->first_name = 'ade';
        $person->last_name = 'nafil';
        $person->save();

        assertNotNull($person->created_at);
        assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
    }

    public function testCustomeCast()
    {
        $person = new Person();

        $person->first_name = 'ade';
        $person->last_name = 'nafil';
        $person->address = new Address('Jensud', 'Berau', 'Indonesia', '77312');
        $person->save();

        assertNotNull($person->created_at);
        assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
        self::assertEquals('Jensud',$person->address->street);
        self::assertEquals('Berau',$person->address->city);
        self::assertEquals('Indonesia',$person->address->country);
        self::assertEquals('77312',$person->address->postal_code);
    }

}
