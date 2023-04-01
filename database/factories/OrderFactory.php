<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $parts = ['screen', 'battery', 'cable', 'hdd', 'ram'];

        return [
            'name' => fake()->randomElement($parts),
            'url' => fake()->url,
            'quantity' => rand(1, 2),
            'cost' => fake()->randomFloat(2, 0, 100),
            'note' => fake()->optional(.2)->text,
            'status' => fake()->randomElement(OrderStatus::values()),
        ];
    }
}
