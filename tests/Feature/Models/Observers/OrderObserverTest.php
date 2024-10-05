<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('can save cancelled order as non-billable', function () {
    $order = Order::factory()->create();

    expect($order->is_billable)->toBeTrue();

    $order->cancel();
    $order->refresh();

    expect($order->is_billable)->toBeFalse();
});

it('can update ticket balance on all events', function () {
    $ticket = Ticket::factory()->hasInvoice()->create();
    $order = Order::factory()->forTicket($ticket)->create();

    // ignore cancelled, non-billable orders
    Order::factory()->forTicket($ticket)->cancelled()->create();
    Order::factory()->forTicket($ticket)->free()->create();

    $ticket->refresh();

    expect($ticket->balance)->toBe(-$order->cost);

    // update order cost
    $order->update(['cost' => 100.0]);
    $ticket->refresh();

    expect($ticket->balance)->toBe(-100.0);

    // delete order
    $order->delete();
    $ticket->refresh();

    expect($ticket->balance)->toBe(0.0);
});

it('can update ticket order counters on all events', function () {
    $ticket = Ticket::factory()->hasInvoice()->create();
    $order = Order::factory()->forTicket($ticket)->create();
    Order::factory()->forTicket($ticket)->cancelled()->create();

    $ticket->refresh();

    expect($ticket->total_orders_count)->toBe(2);
    expect($ticket->completed_orders_count)->toBe(1);

    // update order status
    $order->update(['status' => OrderStatus::Received]);
    $ticket->refresh();

    expect($ticket->total_orders_count)->toBe(2);
    expect($ticket->completed_orders_count)->toBe(2);

    // delete order
    $order->delete();
    $ticket->refresh();

    expect($ticket->total_orders_count)->toBe(1);
    expect($ticket->completed_orders_count)->toBe(1);
});
