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
            'name' => $this->faker->randomElement($parts),
            'url' => $this->faker->url,
            'quantity' => rand(1, 2),
            'cost' => $this->faker->randomFloat(2, 0, 100),
            'note' => $this->faker->optional(.2)->text,
            'status' => $this->faker->randomElement(OrderStatus::values()),
        ];
    }
}
