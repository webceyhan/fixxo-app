<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum Progress: string
{
    use HasValues;

    // When an entity is created, or on-hold, or waiting for something.
    case PENDING = 'pending';

    // When an entity is in progress, or being processed.
    case PROCESSING = 'processing';

    // When an ongoing process is completed for an entity.
    case COMPLETED = 'completed';

    /**
     * Get the flag indicating if the progress is pending.
     */
    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    /**
     * Get the flag indicating if the progress is processing.
     */
    public function isProcessing(): bool
    {
        return $this === self::PROCESSING;
    }

    /**
     * Get the flag indicating if the progress is completed.
     */
    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }
}
