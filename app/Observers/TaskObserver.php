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
        $task->ticket->fillBalance()->fillTaskCounters()->save();
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if ($task->wasChanged(['cost', 'status'])) {
            $task->ticket->fillBalance()->fillTaskCounters()->save();
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        $task->ticket->fillBalance()->fillTaskCounters()->save();
    }
}
