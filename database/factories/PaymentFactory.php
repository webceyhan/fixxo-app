<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(PaymentType::values());
        $sign = $type === PaymentType::REFUND ? '-' : '';

        return [
            'amount' => $sign . fake()->randomFloat(2, 0, 100),
            'type' => $type,
            'method' => fake()->randomElement(PaymentMethod::values()),
            'notes' => fake()->optional(.2)->text,
            // 'created_at' => fake()->dateTimeThisYear(),
        ];
    }
}
