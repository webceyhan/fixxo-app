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
        $task->ticket->setBalance()->setTaskCounters()->save();
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if ($task->wasChanged('cost')) {
            $task->ticket->setBalance();
        }

        if ($task->wasChanged('status')) {
            $task->ticket->setTaskCounters();
        }

        $task->ticket->isDirty() && $task->ticket->save();
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        $task->ticket->setBalance()->setTaskCounters()->save();
    }
}
