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
            'iMac' => DeviceType::Desktop,
            'MacBook' => DeviceType::Laptop,
            'iPad' => DeviceType::Tablet,
            'iPhone' => DeviceType::Phone,
        ],
        'Samsung' => [
            'Galaxy' => DeviceType::Phone,
            'Galaxy Tab' => DeviceType::Tablet,
        ],
        'Sony' => [
            'Vaio' => DeviceType::Laptop,
            'PlayStation' => DeviceType::Console,
        ],
        'Hp' => [
            'Pavilion' => DeviceType::Desktop,
            'Deskjet' => DeviceType::Printer,
        ],
        'Lenovo' => [
            'Thinkpad' => DeviceType::Laptop,
        ],
        'TomTom' => [
            'Go Comfort' => DeviceType::Navigator,
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
