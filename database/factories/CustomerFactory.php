<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 * 
 * @method static hasDevices(int $count = 1, array $attributes = [])
 * @method static hasTickets(int $count = 1, array $attributes = [])
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'address' => fake()->address(),
            'note' => fake()->sentence(),
        ];
    }

    // STATES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Indicate that the customer has a company name and VAT number.
     */
    public function withCompany(): static
    {
        return $this->state(fn (array $attributes) => [
            'company' => fake()->company(),
            'vat_number' => fake()->unique()->ean13(),
        ]);
    }

    /**
     * Indicate that the customer has no email address.
     */
    public function withoutEmail(): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => null,
        ]);
    }

    /**
     * Indicate that the customer has no phone number.
     */
    public function withoutPhone(): static
    {
        return $this->state(fn (array $attributes) => [
            'phone' => null,
        ]);
    }

    public function withoutAddress(): static
    {
        return $this->state(fn (array $attributes) => [
            'address' => null,
        ]);
    }

    /**
     * Indicate that the transaction has no note.
     */
    public function withoutNote(): static
    {
        return $this->state(fn (array $attributes) => [
            'note' => null,
        ]);
    }
}
