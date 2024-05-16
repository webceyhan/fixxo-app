<?php

namespace Database\Factories;

use App\Enums\TransactionType;
use App\Enums\TransactionMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2, 10, 100),
            'type' => fake()->randomElement(TransactionType::values()),
            'method' => fake()->randomElement(TransactionMethod::values()),
            'note' => fake()->optional(.2)->text,
        ];
    }

    /**
     * Indicate that the model's type is discount.
     *
     * @return $this
     */
    public function discount(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => TransactionType::Discount,
        ]);
    }

    /**
     * Indicate that the model's type is payment.
     *
     * @return $this
     */
    public function payment(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => TransactionType::Payment,
        ]);
    }
}
