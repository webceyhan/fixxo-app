<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 * 
 * @method static hasTransactions(int $count = 1, array $attributes = [])
 */
class InvoiceFactory extends Factory
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
            'total' => fake()->randomFloat(2, 10, 100),
            'is_paid' => false,
            'due_date' => now()->addWeek(),
            'balance' => 0,
        ];
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Indicate that the invoice belongs to the specified ticket.
     */
    public function forTicket(Ticket $ticket): static
    {
        return $this->state(fn(array $attributes) => [
            'ticket_id' => $ticket->id,
            'total' => $ticket->balance,
            'created_at' => $ticket->created_at,
            'due_date' => $ticket->created_at->addWeek(),
        ]);
    }

    // STATES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Indicate that the invoice has been paid.
     */
    public function paid(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_paid' => true,
        ]);
    }

    /**
     * Indicate that the invoice is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn(array $attributes) => [
            'due_date' => Carbon::parse($attributes['created_at'] ?? now())->subWeek(),
        ]);
    }
}
