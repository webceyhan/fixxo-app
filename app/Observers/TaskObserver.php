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
        $ticket->completed_tasks_count += $task->completed_at ? 1 : 0;
        $ticket->total_tasks_count += 1;

        $ticket->save();
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        $ticket = $task->ticket;

        // update ticket's balance if task cost was changed
        if ($task->wasChanged('cost')) {
            $ticket->calculateBalance();
        }

        // update ticket's completed task counter if applicable
        if ($task->wasChanged('completed_at')) {
            $ticket->completed_tasks_count += $task->completed_at ? 1 : -1;
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
        $ticket->completed_tasks_count -= $task->completed_at ? 1 : 0;
        $ticket->total_tasks_count -= 1;

        $ticket->save();
    }
}
