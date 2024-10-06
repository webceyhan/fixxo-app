<?php

use App\Enums\Priority;
use App\Enums\TicketStatus;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Order;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('can initialize ticket', function () {
    $ticket = new Ticket();

    expect($ticket->id)->toBeNull();
    expect($ticket->assignee_id)->toBeNull();
    expect($ticket->customer_id)->toBeNull();
    expect($ticket->description)->toBeNull();
    expect($ticket->priority)->toBe(Priority::Normal);
    expect($ticket->status)->toBe(TicketStatus::New);
    expect($ticket->due_date)->toBeNull();
    expect($ticket->created_at)->toBeNull();
    expect($ticket->updated_at)->toBeNull();
    expect($ticket->balance)->toBe(0.0);
    expect($ticket->total_tasks_count)->toBe(0);
    expect($ticket->completed_tasks_count)->toBe(0);
    expect($ticket->total_orders_count)->toBe(0);
    expect($ticket->completed_orders_count)->toBe(0);
});

it('can create ticket', function () {
    $ticket = Ticket::factory()->create();

    expect($ticket->id)->toBeInt();
    expect($ticket->assignee_id)->toBeNull();
    expect($ticket->customer_id)->toBeInt();
    expect($ticket->description)->toBeString();
    expect($ticket->priority)->toBe(Priority::Normal);
    expect($ticket->status)->toBe(TicketStatus::New);
    expect($ticket->due_date)->toBeInstanceOf(Carbon::class);
    expect($ticket->created_at)->toBeInstanceOf(Carbon::class);
    expect($ticket->updated_at)->toBeInstanceOf(Carbon::class);
    expect($ticket->balance)->toBe(0.0);
    expect($ticket->total_tasks_count)->toBe(0);
    expect($ticket->completed_tasks_count)->toBe(0);
    expect($ticket->total_orders_count)->toBe(0);
    expect($ticket->completed_orders_count)->toBe(0);
});

it('can create ticket with assignee', function () {
    $ticket = Ticket::factory()->assigned()->create();

    expect($ticket->assignee->id)->toBeInt();
});

it('can create ticket of priority', function () {
    $ticket = Ticket::factory()->ofPriority(Priority::High)->create();

    expect($ticket->priority)->toBe(Priority::High);
});

it('can create ticket of status', function () {
    $ticket = Ticket::factory()->ofStatus(TicketStatus::Closed)->create();

    expect($ticket->status)->toBe(TicketStatus::Closed);
});

it('can create an overdue ticket', function () {
    $ticket = Ticket::factory()->overdue()->create();

    expect($ticket->due_date)->toBeInstanceOf(Carbon::class);
    expect($ticket->due_date->isPast())->toBeTrue();
});

it('can update ticket', function () {
    $ticket = Ticket::factory()->create();

    $ticket->update([
        'description' => 'Repair iPhone 13 Pro',
        'priority' => Priority::High,
        'status' => TicketStatus::InProgress,
        'due_date' => now()->addMonth(),
    ]);

    expect($ticket->description)->toBe('Repair iPhone 13 Pro');
    expect($ticket->priority)->toBe(Priority::High);
    expect($ticket->status)->toBe(TicketStatus::InProgress);
    expect($ticket->due_date->isFuture())->toBeTrue();
});

it('can delete ticket', function () {
    $ticket = Ticket::factory()->create();

    $ticket->delete();

    expect(Ticket::find($ticket->id))->toBeNull();
});

// Customer ////////////////////////////////////////////////////////////////////////////////////////

it('belongs to a customer', function () {
    $customer = Customer::factory()->create();
    $ticket = Ticket::factory()->forCustomer($customer)->create();

    expect($ticket->customer)->toBeInstanceOf(Customer::class);
    expect($ticket->customer->id)->toBe($customer->id);
});

// Device //////////////////////////////////////////////////////////////////////////////////////////

it('belongs to a device', function () {
    $device = Device::factory()->create();
    $ticket = Ticket::factory()->forDevice($device)->create();

    expect($ticket->device)->toBeInstanceOf(Device::class);
    expect($ticket->device->id)->toBe($device->id);
});

// Tasks ///////////////////////////////////////////////////////////////////////////////////////////

it('can have many tasks', function () {
    $ticket = Ticket::factory()->hasTasks(2)->create();

    expect($ticket->tasks)->toHaveCount(2);
});

it('can delete ticket with tasks', function () {
    $ticket = Ticket::factory()->hasTasks(2)->create();

    $ticket->delete();

    expect(Ticket::find($ticket->id))->toBeNull();
    expect(Task::count())->toBe(0);
});

// Orders //////////////////////////////////////////////////////////////////////////////////////////

it('can have many orders', function () {
    $ticket = Ticket::factory()->hasOrders(2)->create();

    expect($ticket->orders)->toHaveCount(2);
});

it('can delete ticket with orders', function () {
    $ticket = Ticket::factory()->hasOrders(2)->create();

    $ticket->delete();

    expect(Ticket::find($ticket->id))->toBeNull();
    expect(Order::count())->toBe(0);
});

// Status ////////////////////////////////////////////////////////////////////////////////////////

it('can filter tickets by status scope', function (TicketStatus $status) {
    Ticket::factory()->ofStatus($status)->create();

    expect(Ticket::ofStatus($status)->count())->toBe(1);
    expect(Ticket::ofStatus($status)->first()->status)->toBe($status);
})->with(TicketStatus::cases());

// Total Cost //////////////////////////////////////////////////////////////////////////////////////

it('can update ticket balance automatically', function () {
    $ticket = Ticket::factory()->create();
    $task = Task::factory()->forTicket($ticket)->create();
    $order = Order::factory()->forTicket($ticket)->create();

    // ignore cancelled, non-billable tasks, orders
    Task::factory()->forTicket($ticket)->cancelled()->create();
    Order::factory()->forTicket($ticket)->cancelled()->create();

    $ticket->refresh();

    expect($ticket->balance)->toBe(-round($task->cost + $order->cost, 2));
});

// Task Counters ///////////////////////////////////////////////////////////////////////////////////

it('can update ticket task counters automatically', function () {
    $ticket = Ticket::factory()->create();
    Task::factory()->forTicket($ticket)->create();
    Task::factory()->forTicket($ticket)->cancelled()->create();

    $ticket->refresh();

    expect($ticket->total_tasks_count)->toBe(2);
    expect($ticket->completed_tasks_count)->toBe(1);
});

// Order Counters //////////////////////////////////////////////////////////////////////////////////

it('can update ticket order counters automatically', function () {
    $ticket = Ticket::factory()->create();
    Order::factory()->forTicket($ticket)->create();
    Order::factory()->forTicket($ticket)->cancelled()->create();

    $ticket->refresh();

    expect($ticket->total_orders_count)->toBe(2);
    expect($ticket->completed_orders_count)->toBe(1);
});
