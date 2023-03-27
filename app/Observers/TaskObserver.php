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

        // credit ticket's balance with task cost
        $ticket->balance -= $task->cost;

        // increase pending-task-count if applicable
        if (!$task->completed_at) {
            $ticket->pending_task_count += 1;
        }

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
            $ticket->balance += $task->getOriginal('cost'); // debit previous
            $ticket->balance -= $task->cost; // credit new task cost
        }

        // update ticket's pending-task-count if changed
        if ($task->wasChanged('completed_at')) {
            $ticket->pending_task_count += !$task->completed_at ? 1 : -1;
        }

        $ticket->isDirty() && $ticket->save();
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        $ticket = $task->ticket;
        $isPending = !$task->completed_at;

        // debit ticket balance
        $ticket->balance += $task->cost;

        // descrease ticket pending-task count if applicable
        $isPending && $ticket->pending_task_count -= 1;

        $ticket->save();
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
