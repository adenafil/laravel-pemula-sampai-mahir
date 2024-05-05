<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    public function testFactory()
    {
        $employee1 = Employee::factory()->programmer()->make([
            'id' => '1',
            'name' => 'Employee 1'
        ]);
//        $employee1->id = '1';
//        $employee1->name = 'Employee 1';
        $employee1->save();

        self::assertNotNull(Employee::where('id', '1')->first());

        $employee2 = Employee::factory()->seniorProgrammer()->create([
            'id' => '2',
            'name' => 'Employee 2'
        ]);

        self::assertNotNull($employee2);
        self::assertNotNull(Employee::where('id', 2)->first());

        $employee3 = Employee::factory()->create([
           'id' => '3',
           'name' => 'Employee 3',
            'title' => 'Boss',
            'salary' => 1_000_000_000
        ]);
    }
}
