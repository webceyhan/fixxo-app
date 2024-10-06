<?php

use App\Models\Invoice;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());

    $this->ticket = Ticket::factory()->has(Task::factory(['cost' => 100]))->create();
});

it('can update invoice total_paid on all events as payment', function () {
    $invoice = Invoice::factory()->forTicket($this->ticket)->create();
    $transaction = Transaction::factory()->forInvoice($invoice)->create(['amount' => 50.0]);

    $invoice->refresh();

    expect($invoice->total_paid)->toBe(50.0);
    expect($invoice->balance)->toBe(-50.0);

    // update transaction amount
    $transaction->update(['amount' => 100.0]);
    $invoice->refresh();

    expect($invoice->total_paid)->toBe(100.0);
    expect($invoice->balance)->toBe(0.0);

    // delete transaction
    $transaction->delete();
    $invoice->refresh();

    expect($invoice->total_paid)->toBe(0.0);
    expect($invoice->balance)->toBe(-100.0);
});

it('can update invoice total_paid on all events as refund', function () {
    $invoice = Invoice::factory()->forTicket($this->ticket)->create();
    $transaction = Transaction::factory()->forInvoice($invoice)->refund()->create(['amount' => 50.0]);

    $invoice->refresh();

    expect($invoice->total_paid)->toBe(50.0);
    expect($invoice->balance)->toBe(-50.0);

    // update transaction amount
    $transaction->update(['amount' => 100.0]);
    $invoice->refresh();

    expect($invoice->total_paid)->toBe(100.0);
    expect($invoice->balance)->toBe(0.0);

    // delete transaction
    $transaction->delete();
    $invoice->refresh();

    expect($invoice->total_paid)->toBe(0.0);
    expect($invoice->balance)->toBe(-100.0);
});
