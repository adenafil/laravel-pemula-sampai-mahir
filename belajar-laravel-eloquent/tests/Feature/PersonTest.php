<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

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
}
