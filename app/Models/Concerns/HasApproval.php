<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @property Carbon|null $approved_at
 *
 * @method static Builder|static approved()
 */
trait HasApproval
{
    private const APPROVED_AT = 'approved_at';

    /**
     * Initialize the trait for an instance.
     */
    public function initializeHasApproval(): void
    {
        $this->casts[static::APPROVED_AT] = 'datetime';
    }

    /**
     * Determine if the model is approved.
     */
    public function isApproved(): bool
    {
        return $this->{static::APPROVED_AT} !== null;
    }

    // SCOPES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include approved models.
     */
    public function scopeApproved(Builder $query): void
    {
        $query->whereNotNull(static::APPROVED_AT);
    }
}
