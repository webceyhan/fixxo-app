<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function (User $user) {
            // random date since user creation
            $startDate = fn() => fake()->dateTimeBetween($user->created_at);

            // customer
            Customer::factory()->create([
                'created_at' => $startDate,
            ]);

            // customer with company
            Customer::factory()->withCompany()->create([
                'created_at' => $startDate,
            ]);

            // customer without email
            Customer::factory()->withoutEmail()->create([
                'created_at' => $startDate,
            ]);

            // customer without phone
            Customer::factory()->withoutPhone()->create([
                'created_at' => $startDate,
            ]);

            // customer without address
            Customer::factory()->withoutAddress()->create([
                'created_at' => $startDate,
            ]);

            // customer without note
            Customer::factory()->withoutNote()->create([
                'created_at' => $startDate,
            ]);
        });
    }
}
