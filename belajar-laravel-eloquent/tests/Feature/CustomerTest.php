<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class CustomerTest extends TestCase
{
    public function testOneToOne()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);

        $customer = Customer::query()->find('ADE');
        self::assertNotNull($customer);

        $wallet = $customer->wallet;
        self::assertNotNull($wallet);

        self::assertEquals(1_000_000, $wallet->amount);
    }

    public function testOneToOneQuery()
    {
        $customer = new Customer();
        $customer->id = 'ADE';
        $customer->name = 'Ade';
        $customer->email = 'ade@pzn.com';
        $customer->save();

        $wallet = new Wallet();
        $wallet->amount = 1_000_000;
        $customer->wallet()->save($wallet);

        self::assertNotNull($wallet->customer_id);
    }

    public function testHasOneThrough()
    {
        $this->seed([
            CustomerSeeder::class,
            WalletSeeder::class,
            VirtualAccountSeeder::class
        ]);

        $customer = Customer::find('ADE');
        assertNotNull($customer);

        $virtualAccount = $customer->virtualAccount;
        assertNotNull($virtualAccount);
        assertEquals('BCA', $virtualAccount->bank);
    }

    public function testManyToMany()
    {
        $this->seed([
           CustomerSeeder::class,
           CategorySeeder::class,
           ProductSeeder::class
        ]);

        $customer = Customer::find('ADE');
        self::assertNotNull($customer);

        $customer->likeProducts()->attach('1');
        $customer->likeProducts()->attach('2');

        $products = $customer->likeProducts;
        self::assertCount(2, $products);

        self::assertEquals('2', $products[1]->id);
    }

    public function testManyToManyDetach()
    {
        $this->testManyToMany();

        $customer = Customer::find('ADE');
        $customer->likeProducts()->detach('2');
        $customer->likeProducts()->detach('1');

        $products = $customer->likeProducts;
        self::assertCount(0, $products);
    }
}
