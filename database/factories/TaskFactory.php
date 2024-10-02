<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Enums\TaskType;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
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
            'description' => fake()->sentence(),
            'cost' => fake()->randomFloat(2, 10, 100),
            'type' => TaskType::Repair,
            'status' => TaskStatus::New,
        ];
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Indicate that the task belongs to the specified ticket.
     */
    public function forTicket(Ticket $ticket): self
    {
        return $this->state(fn(array $attributes) => [
            'ticket_id' => $ticket->id,
            'created_at' => $ticket->created_at,
        ]);
    }

    // STATES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Indicate that the task has the specified type.
     */
    public function ofType(TaskType $type): self
    {
        return $this->state(fn(array $attributes) => [
            'type' => $type,
        ]);
    }

    /**
     * Indicate that the task has specified status.
     */
    public function ofStatus(TaskStatus $status): self
    {
        return $this->state(fn(array $attributes) => [
            'status' => $status,
        ]);
    }

    /**
     * Indicate that the task is cancelled.
     */
    public function cancelled(): self
    {
        return $this->ofStatus(TaskStatus::Cancelled);
    }

    /**
     * Indicate that the task is approved.
     */
    public function approved(): self
    {
        return $this->state(fn(array $attributes) => [
            'approved_at' => now(),
        ]);
    }
}
