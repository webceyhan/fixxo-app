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

        // credit ticket's balance
        $ticket->balance -= $task->cost;

        // update ticket's total-task-count
        $ticket->total_task_count += 1;

        // increase ticket's completed-task-count if applicable
        $ticket->completed_task_count += $task->completed_at ? 1 : 0;

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

        // update ticket's completed-task-count if task completion was changed
        if ($task->wasChanged('completed_at')) {
            $ticket->completed_task_count += $task->completed_at ? 1 : -1;
        }

        $ticket->isDirty() && $ticket->save();
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        $ticket = $task->ticket;

        // debit ticket balance
        $ticket->balance += $task->cost;

        // update ticket's total-task-count
        $ticket->total_task_count -= 1;

        // descrease ticket's completed-task-count if applicable
        $ticket->completed_task_count -= $task->completed_at ? 1 : 0;

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
