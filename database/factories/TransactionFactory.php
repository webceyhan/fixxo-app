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
            'amount' => fake()->randomFloat(2, 0, 100),
            'type' => fake()->randomElement(TransactionType::values()),
            'method' => fake()->randomElement(TransactionMethod::values()),
            'note' => fake()->optional(.2)->text,
        ];
    }
}
