<?php

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('can save cancelled task as non-billable', function () {
    $task = Task::factory()->create();

    expect($task->is_billable)->toBeTrue();

    $task->cancel();
    $task->refresh();

    expect($task->is_billable)->toBeFalse();
});

it('can update ticket balance on all events', function () {
    $ticket = Ticket::factory()->hasInvoice()->create();
    $task = Task::factory()->forTicket($ticket)->create();

    // ignore cancelled, non-billable tasks
    Task::factory()->forTicket($ticket)->cancelled()->create();
    Task::factory()->forTicket($ticket)->free()->create();

    $ticket->refresh();

    expect($ticket->balance)->toBe($task->cost);

    // update task cost
    $task->update(['cost' => 100.0]);
    $ticket->refresh();

    expect($ticket->balance)->toBe(100.0);

    // delete task
    $task->delete();
    $ticket->refresh();

    expect($ticket->balance)->toBe(0.0);
});

it('can update ticket task counters on all events', function () {
    $ticket = Ticket::factory()->create();
    $task = Task::factory()->forTicket($ticket)->create();
    Task::factory()->forTicket($ticket)->cancelled()->create();

    $ticket->refresh();

    expect($ticket->total_tasks_count)->toBe(2);
    expect($ticket->completed_tasks_count)->toBe(1);

    // update task status
    $task->update(['status' => TaskStatus::Completed]);
    $ticket->refresh();

    expect($ticket->total_tasks_count)->toBe(2);
    expect($ticket->completed_tasks_count)->toBe(2);

    // delete task
    $task->delete();
    $ticket->refresh();

    expect($ticket->total_tasks_count)->toBe(1);
    expect($ticket->completed_tasks_count)->toBe(1);
});
