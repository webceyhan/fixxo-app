<?php

use App\Models\Ticket;

it('can determine if ticket is overdue', function () {
    $ticket = Ticket::factory()->overdue()->create();

    expect($ticket->isOverdue())->toBeTrue();
    expect($ticket->due_date)->isPast();
});

it('can filter tickets by overdue scope', function () {
    Ticket::factory()->create();
    Ticket::factory()->overdue()->create();

    expect(Ticket::overdue()->count())->toBe(1);
    expect(Ticket::overdue()->first()->isOverdue())->toBeTrue();
});
