<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        $ticket = $task->ticket;

        // update ticket's balance
        $ticket->calculateBalance();

        // update ticket's task counters accordingly
        $ticket->calculateTaskCounters();

        $ticket->save();
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        $ticket = $task->ticket;

        // update ticket's balance if applicable
        if ($task->wasChanged('cost')) {
            $ticket->calculateBalance();
        }

        // update ticket's task counters if applicable
        if ($task->wasChanged('completed_at')) {
            $ticket->calculateTaskCounters();
        }

        $ticket->isDirty() && $ticket->save();
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        $ticket = $task->ticket;

        // update ticket's balance
        $ticket->calculateBalance();

        // update ticket's task counters accordingly
        $ticket->calculateTaskCounters();

        $ticket->save();
    }
}
