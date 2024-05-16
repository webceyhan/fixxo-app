<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;
use App\Models\Task;

enum TaskStatus: string
{
    use HasValues;

    case Pending = 'pending';
    case Completed = 'completed';

    /**
     * Get the progress for the task status.
     */
    public function progress(): Progress
    {
        return match ($this) {
            self::Pending => Progress::Pending,
            self::Completed => Progress::Completed,
        };
    }

    /**
     * Get the status for the given task.
     */
    public static function fromModel(Task $task): self
    {
        return $task->completed_at ? self::Completed : self::Pending;
    }
}
