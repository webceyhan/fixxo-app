<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;
use App\Models\Task;

enum TaskStatus: string
{
    use HasBase;

    case PENDING = 'pending';
    case COMPLETED = 'completed';

    /**
     * Get the progress for the task status.
     */
    public function progress(): Progress
    {
        return match ($this) {
            self::PENDING => Progress::PENDING,
            self::COMPLETED => Progress::COMPLETED,
        };
    }

    /**
     * Get the status for the given task.
     */
    public static function fromModel(Task $task): self
    {
        return $task->completed_at ? self::COMPLETED : self::PENDING;
    }
}
