<?php

namespace Database\Factories;

use App\Enums\Priority;
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
            'description' => fake()->text,
            'note' => fake()->optional(.2)->text,
            'priority' => fake()->randomElement(Priority::values()),
            'status' => fake()->randomElement(TicketStatus::values()),
            'created_at' => fake()->dateTimeThisYear(),
        ];
    }
}
