<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Customer::all()->each(function ($customer) use ($users) {
            // login as a random user
            auth()->login($users->random(1)->first());

            Device::factory()->forCustomer($customer)->create();
        });
    }
}
