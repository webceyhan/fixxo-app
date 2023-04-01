<?php

namespace Database\Factories;

use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'address' => fake()->address,
            'phone' => fake()->e164PhoneNumber,
            'email' => fake()->optional()->safeEmail,
            'note' => fake()->optional(.2)->text,
            'status' => fake()->randomElement(UserStatus::values()),
            'created_at' => fake()->dateTimeThisYear()
        ];

        // TODO: add trashed state
    }
}
