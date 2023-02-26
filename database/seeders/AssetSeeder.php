<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Customer::all()->each(function ($customer) use ($users) {

            $amount = rand(1, 2);

            Asset::factory($amount)->create([
                'customer_id' => fn () => $customer->id,
                'user_id' => fn () => $users->random(1)->first(),
            ]);
        });
    }
}
