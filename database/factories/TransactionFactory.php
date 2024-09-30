<?php

namespace Database\Factories;

use App\Enums\TransactionMethod;
use App\Enums\TransactionType;
use App\Models\Ticket;
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
            'ticket_id' => Ticket::factory(),
            'amount' => fake()->randomFloat(2, 10, 100),
            'note' => fake()->sentence(),
            'method' => TransactionMethod::Cash,
            'type' => TransactionType::Payment,
        ];
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Indicate that the transaction belongs to the specified ticket.
     */
    public function forTicket(Ticket $ticket): self
    {
        return $this->state(fn(array $attributes) => [
            'ticket_id' => $ticket->id,
            'created_at' => fake()->dateTimeBetween($ticket->created_at),
        ]);
    }

    // STATES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Indicate that the transaction has no note.
     */
    public function withoutNote(): self
    {
        return $this->state(fn(array $attributes) => [
            'note' => null,
        ]);
    }

    /**
     * Indicate that the transaction is of a specified method.
     */
    public function ofMethod(TransactionMethod $method): self
    {
        return $this->state(fn(array $attributes) => [
            'method' => $method,
        ]);
    }

    /**
     * Indicate that the transaction is of a specified type.
     */
    public function ofType(TransactionType $type): self
    {
        return $this->state(fn(array $attributes) => [
            'type' => $type,
        ]);
    }

    /**
     * Indicate that the transaction is a discount.
     */
    public function discount(): self
    {
        return $this->ofType(TransactionType::Discount);
    }

    /**
     * Indicate that the transaction is a refund.
     */
    public function refund(): self
    {
        return $this->ofType(TransactionType::Refund);
    }
}
