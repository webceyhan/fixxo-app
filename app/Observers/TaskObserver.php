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
        $task->load('ticket');
        $task->ticket->fillBalance()->fillTaskCounters()->save();
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if ($task->wasChanged(['cost', 'is_billable', 'status'])) {
            $task->load('ticket');
            $task->ticket->fillBalance()->fillTaskCounters()->save();
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        $task->load('ticket');
        $task->ticket->fillBalance()->fillTaskCounters()->save();
    }

    /**
     * Handle the Task "saving" event.
     */
    public function saving(Task $task): void
    {
        if ($task->isCancelled()) {
            $task->is_billable = false;
        }
    }
}
