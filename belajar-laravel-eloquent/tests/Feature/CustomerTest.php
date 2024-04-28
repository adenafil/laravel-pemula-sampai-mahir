<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CustomerSeeder;
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
}
