<?php

namespace Database\Factories;

use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => fake()->text,
            'note' => fake()->optional(.2)->text,
            'status' => fake()->randomElement(TicketStatus::values()),
            'created_at' => fake()->dateTimeThisYear(),
        ];
    }
}
