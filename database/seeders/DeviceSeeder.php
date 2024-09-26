<?php

namespace Database\Seeders;

use App\Enums\DeviceType;
use App\Models\Customer;
use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    const MODEL_BRANDS = [
        'iMac' => 'Apple',
        'Mac' => 'Apple',
        'MacBook' => 'Apple',
        'iPad' => 'Apple',
        'iPhone' => 'Apple',
        'Galaxy' => 'Samsung',
        'Galaxy Tab' => 'Samsung',
        'Vaio' => 'Sony',
        'PlayStation' => 'Sony',
        'Pavilion' => 'Hp',
        'Deskjet' => 'Hp',
        'Thinkpad' => 'Lenovo',
        'Go Comfort' => 'TomTom',
    ];

    const MODEL_VERSIONS = [
        'iMac' => ['21"', '27"'],
        'Mac' => ['Mini', 'Pro', 'Studio'],
        'MacBook' => ['Air', 'Pro'],
        'iPad' => ['Mini', 'Air', 'Pro'],
        'iPhone' => ['SE', 'X', 'Pro', 'Max', 'Pro Max'],
        'Galaxy' => ['S10', 'S20', 'S21'],
        'Galaxy Tab' => ['A', 'S', 'E'],
        'Vaio' => ['Pro', 'Slim'],
        'PlayStation' => ['4', '5'],
        'Pavilion' => ['Gaming', 'Business'],
        'Deskjet' => ['1000', '2000'],
        'Thinkpad' => ['X1', 'T'],
        'Go Comfort' => ['5"', '6"'],
    ];

    const MODEL_TYPES = [
        'iMac' => DeviceType::Desktop,
        'Mac' => DeviceType::Desktop,
        'MacBook' => DeviceType::Laptop,
        'iPad' => DeviceType::Tablet,
        'iPhone' => DeviceType::Phone,
        'Galaxy' => DeviceType::Phone,
        'Galaxy Tab' => DeviceType::Tablet,
        'Vaio' => DeviceType::Laptop,
        'PlayStation' => DeviceType::Other,
        'Pavilion' => DeviceType::Desktop,
        'Deskjet' => DeviceType::Other,
        'Thinkpad' => DeviceType::Laptop,
        'Go Comfort' => DeviceType::Other,
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Customer::all()->each(function ($customer) use ($users) {
            // login as a random user
            auth()->login($users->random(1)->first());

            $model = fake()->randomElement(array_keys(self::MODEL_BRANDS));
            $version = fake()->randomElement(self::MODEL_VERSIONS[$model]);

            Device::factory()->forCustomer($customer)->create([
                'model' => "{$model} {$version}",
                'brand' => self::MODEL_BRANDS[$model],
                'type' => self::MODEL_TYPES[$model],
            ]);
        });
    }
}
