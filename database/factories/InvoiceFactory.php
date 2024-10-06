<?php

namespace Database\Factories;

use App\Models\Invoice;
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
            'due_date' => now()->addWeek(),
            'balance' => -fake()->randomFloat(2, 0, 50),
        ];
    }

        /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (Invoice $invoice) {
            // workaround for testing purposes!
            // remove auto-generated invoice using ticket observer
            // to avoid duplicate invoices for the same ticket
            // TODO: find a better solution
            Ticket::find($invoice->ticket_id)->invoice()->delete();
        });
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
            'balance' => 0, // TODO: ensure total and total_paid are equal instead of setting balance to 0
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
