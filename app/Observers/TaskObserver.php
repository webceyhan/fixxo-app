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
        $task->ticket->updateAggregateFields();
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        // update ticket's aggregate fields if applicable
        if ($task->wasChanged(['cost', 'completed_at'])) {
            $task->ticket->updateAggregateFields();
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        $task->ticket->updateAggregateFields();
    }
}
