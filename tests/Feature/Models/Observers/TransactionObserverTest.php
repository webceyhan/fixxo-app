<?php

use App\Models\Ticket;
use App\Models\Transaction;

it('can update ticket total_paid on all events as payment', function () {
    $ticket = Ticket::factory()->hasInvoice()->create();
    $transaction = Transaction::factory()->forTicket($ticket)->create();

    $ticket->refresh();

    expect($ticket->invoice->total_paid)->toBe($transaction->amount);

    // update transaction amount
    $transaction->update(['amount' => 100.0]);
    $ticket->refresh();

    expect($ticket->invoice->total_paid)->toBe(100.0);

    // delete transaction
    $transaction->delete();
    $ticket->refresh();

    expect($ticket->invoice->total_paid)->toBe(0.0);
});

it('can update ticket total_paid on all events as refund', function () {
    $ticket = Ticket::factory()->hasInvoice()->create();
    $transaction = Transaction::factory()->forTicket($ticket)->refund()->create();

    $ticket->refresh();

    expect($ticket->invoice->total_paid)->toBe($transaction->amount);

    // update transaction amount
    $transaction->update(['amount' => 100.0]);
    $ticket->refresh();

    expect($ticket->invoice->total_paid)->toBe(100.0);

    // delete transaction
    $transaction->delete();
    $ticket->refresh();

    expect($ticket->invoice->total_paid)->toBe(0.0);
});
