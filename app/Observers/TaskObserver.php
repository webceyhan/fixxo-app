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
        $task->ticket->hydrateBalance()->hydrateTaskCounters()->save();
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if ($task->wasChanged('cost')) {
            $task->ticket->hydrateBalance();
        }

        if ($task->wasChanged('completed_at')) {
            $task->ticket->hydrateTaskCounters();
        }

        $task->ticket->isDirty() && $task->ticket->save();
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        $task->ticket->hydrateBalance()->hydrateTaskCounters()->save();
    }
}
