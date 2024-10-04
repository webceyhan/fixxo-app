<?php

namespace Database\Factories;

use App\Enums\Priority;
use App\Enums\TicketStatus;
use App\Models\Customer;
use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 * 
 * @method static hasTasks(int $count = 1, array $attributes = [])
 * @method static hasOrders(int $count = 1, array $attributes = [])
 * @method static hasTransactions(int $count = 1, array $attributes = [])
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
            'customer_id' => Customer::factory(),
            'device_id' => function (array $attributes) {
                // Workaround:
                // due to nested customer factory used in DeviceFactory definition, 
                // multiple customers are created for the same ticket which are not related to each other
                // so we pass the customer_id manually instead of 'device_id' => Device::factory(),
                return Device::factory()->state(['customer_id' => $attributes['customer_id']]);
            },
            'description' => fake()->paragraph(),
            'priority' => Priority::Normal,
            'status' => TicketStatus::New,
            'due_date' => now()->addWeek(),
            'balance' => 0,
        ];
    }

    // RELATIONS ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Indicate that the ticket is assigned to the given user.
     */
    public function forAssignee(User $user): self
    {
        return $this->state(fn(array $attributes) => [
            'assignee_id' => $user->id,
        ]);
    }

    /**
     * Indicate that the ticket belongs to the given customer.
     */
    public function forCustomer(Customer $customer): self
    {
        return $this->state(fn(array $attributes) => [
            'customer_id' => $customer->id,
        ]);
    }

    /**
     * Indicate that the ticket belongs to the given device.
     */
    public function forDevice(Device $device): self
    {
        return $this->state(fn(array $attributes) => [
            'device_id' => $device->id,
            'customer_id' => $device->customer_id,
            'created_at' => fake()->dateTimeBetween($device->created_at),
        ])->state(fn(array $attributes) => [
            'due_date' => Carbon::parse($attributes['created_at'])->addWeek(),
        ]);
    }

    // STATES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Indicate that the ticket is assigned to a user.
     */
    public function assigned(): self
    {
        return $this->forAssignee(User::factory()->create());
    }

    /**
     * Indicate that the ticket is of the given priority.
     */
    public function ofPriority(Priority $priority): self
    {
        return $this->state(fn(array $attributes) => [
            'priority' => $priority,
        ]);
    }

    /**
     * Indicate that the ticket is of the given status.
     */
    public function ofStatus(TicketStatus $status): self
    {
        return $this->state(fn(array $attributes) => [
            'status' => $status,
        ]);
    }

    /**
     * Indicate that the ticket is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn(array $attributes) => [
            'due_date' => Carbon::parse($attributes['created_at'] ?? now())->subWeek(),
        ]);
    }
}
