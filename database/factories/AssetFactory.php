<?php

namespace Database\Factories;

use App\Enums\AssetStatus;
use App\Enums\AssetType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{

    const MODELS = [
        'Apple' => [
            'iMac' => AssetType::DESKTOP,
            'MacBook' => AssetType::LAPTOP,
            'iPad' => AssetType::TABLET,
            'iPhone' => AssetType::PHONE,
        ],
        'Samsung' => [
            'Galaxy' => AssetType::PHONE,
            'Galaxy Tab' => AssetType::TABLET,
        ],
        'Sony' => [
            'Vaio' => AssetType::LAPTOP,
            'Playstation' => AssetType::CONSOLE,
        ],
        'Hp' => [
            'Pavilion' => AssetType::DESKTOP,
            'Deskjet' => AssetType::PRINTER,
        ],
        'Lenovo' => [
            'Thinkpad' => AssetType::LAPTOP,
        ],
        'TomTom' => [
            'Go Comfort' => AssetType::NAVIGATOR,
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
            'warranty' => rand(0, 12),
            'problem' => fake()->text,
            'notes' => fake()->optional(.2)->text,
            'status' => fake()->randomElement(AssetStatus::values()),
            'returned_at' => fake()->optional()->dateTime,
            'created_at' => fake()->dateTimeThisYear(),
        ];
    }
}
