<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Ticket;
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
        return [
            'ticket_id' => Ticket::factory(),
            'name' => fake()->name(),
            'url' => fake()->url(),
            'quantity' => rand(1, 2),
            'cost' => fake()->randomFloat(2, 10, 100),
            'status' => OrderStatus::New,
        ];
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    public function forTicket(Ticket $ticket): static
    {
        return $this->state(fn (array $attributes) => [
            'ticket_id' => $ticket->id,
        ]);
    }

    // STATES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Indicate that the order is of a specified status.
     */
    public function ofStatus(OrderStatus $status): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => $status,
        ]);
    }

    /**
     * Indicate that the order is shipped.
     */
    public function shipped(): static
    {
        return $this->ofStatus(OrderStatus::Shipped);
    }

    /**
     * Indicate that the order is received.
     */
    public function received(): static
    {
        return $this->ofStatus(OrderStatus::Received);
    }

    /**
     * Indicate that the order is cancelled.
     */
    public function cancelled(): static
    {
        return $this->ofStatus(OrderStatus::Cancelled);
    }
}
