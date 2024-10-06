<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @property Carbon $due_date
 *
 * @method static Builder|static overdue()
 */
trait HasDueDate
{
    private const DUE_DATE = 'due_date';

    /**
     * Initialize the trait for an instance.
     */
    public function initializeHasDueDate(): void
    {
        $this->casts[static::DUE_DATE] = 'date';
    }

    /**
     * Define the overdue condition for the model.
     * This must be implemented by the model using this trait.
     */
    abstract protected function overdueCondition(): bool;

    /**
     * Determine if the model is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->{static::DUE_DATE}->isPast() && $this->overdueCondition();
    }

    // SCOPES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Return the raw query for the overdue condition.
     * This should be implemented by the model.
     */
    abstract protected function overdueConditionQuery(Builder $query): void;

    /**
     * Scope a query to only include overdue models.
     */
    public function scopeOverdue(Builder $query): void
    {
        $query->where(static::DUE_DATE, '<', now());

        $this->overdueConditionQuery($query);
    }
}
