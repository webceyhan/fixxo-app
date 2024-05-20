<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory(5)->create();

        Customer::factory(5)->withCompany()->create();

        Customer::factory(5)->withoutEmail()->create();

        Customer::factory(5)->withoutPhone()->create();

        Customer::factory(5)->withoutAddress()->create();

        Customer::factory(5)->withoutNote()->create();
    }
}
