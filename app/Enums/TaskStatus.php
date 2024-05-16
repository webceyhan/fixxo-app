<?php

namespace App\Enums;

use App\Enums\Concerns\Completable;
use App\Enums\Concerns\HasValues;
use App\Models\Task;

enum TaskStatus: string
{
    use HasValues, Completable;

    case Pending = 'pending';
    case Completed = 'completed';

    // METHODS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get list of completed enum cases.
     */
    public static function completedCases(): array
    {
        return [
            self::Completed,
        ];
    }

    /**
     * Get the status for the given task.
     */
    public static function fromModel(Task $task): self
    {
        return $task->completed_at ? self::Completed : self::Pending;
    }
}
