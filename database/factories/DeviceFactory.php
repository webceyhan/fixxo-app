<?php

namespace Database\Factories;

use App\Enums\DeviceStatus;
use App\Enums\DeviceType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    const MODELS = [
        'Apple' => [
            'iMac' => DeviceType::DESKTOP,
            'MacBook' => DeviceType::LAPTOP,
            'iPad' => DeviceType::TABLET,
            'iPhone' => DeviceType::PHONE,
        ],
        'Samsung' => [
            'Galaxy' => DeviceType::PHONE,
            'Galaxy Tab' => DeviceType::TABLET,
        ],
        'Sony' => [
            'Vaio' => DeviceType::LAPTOP,
            'PlayStation' => DeviceType::CONSOLE,
        ],
        'Hp' => [
            'Pavilion' => DeviceType::DESKTOP,
            'Deskjet' => DeviceType::PRINTER,
        ],
        'Lenovo' => [
            'Thinkpad' => DeviceType::LAPTOP,
        ],
        'TomTom' => [
            'Go Comfort' => DeviceType::NAVIGATOR,
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brand = fake()->randomElement(array_keys(self::MODELS));
        $model = fake()->randomElement(array_keys(self::MODELS[$brand]));
        $type = self::MODELS[$brand][$model];

        return [
            'name' => $model,
            'brand' => $brand,
            'type' => $type,
            'serial' => fake()->uuid,
            'purchase_date' => fake()->optional(.2)->date(),
            // TODO: add has_warranty accessor to model
            'warranty_expire_date' => fake()->optional(.2)->date(),
            'status' => fake()->randomElement(DeviceStatus::values()),
            'created_at' => fake()->dateTimeThisYear(),
        ];

        // TODO: add states for different device types, has_warranty, status etc.
    }
}
