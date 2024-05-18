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

            auth()->login($users->random(1)->first());

            $amount = rand(1, 2);

            Device::factory($amount)->create([
                'customer_id' => fn () => $customer->id,
                // create date must be later than customer creation
                'created_at' => fn () => fake()->dateTimeBetween($customer->created_at),
            ]);
        });
    }
}
