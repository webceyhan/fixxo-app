<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum Progress: string
{
    use HasValues;

    // When an entity is created, or on-hold, or waiting for something.
    case Pending = 'pending';

    // When an entity is in progress, or being processed.
    case Processing = 'processing';

    // When an ongoing process is completed for an entity.
    case Completed = 'completed';

    /**
     * Get the flag indicating if the progress is pending.
     */
    public function isPending(): bool
    {
        return $this === self::Pending;
    }

    /**
     * Get the flag indicating if the progress is processing.
     */
    public function isProcessing(): bool
    {
        return $this === self::Processing;
    }

    /**
     * Get the flag indicating if the progress is completed.
     */
    public function isCompleted(): bool
    {
        return $this === self::Completed;
    }
}
