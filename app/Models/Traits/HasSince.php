<?php

namespace App\Models\Traits;

use App\Enums\Interval;
use Illuminate\Database\Eloquent\Builder;

/**
 * Extend Eloquent models with scopes to get records created since given interval.
 *
 * @static \Illuminate\Database\Eloquent\Builder since(string $unit = Interval::DAY)
 * @static \Illuminate\Database\Eloquent\Builder sinceToday()
 * @static \Illuminate\Database\Eloquent\Builder sinceThisWeek()
 * @static \Illuminate\Database\Eloquent\Builder sinceThisMonth()
 */
trait HasSince
{
    /**
     * Scope a query to get records created since given interval.
     */
    public function scopeSince(Builder $query, string $unit = Interval::DAY): void
    {
        $query->where('created_at', '>=', Interval::toDate($unit));
    }

    /**
     * Scope a query to get records created since today.
     */
    public function scopeSinceToday(Builder $query): void
    {
        $query->since(Interval::DAY);
    }

    /**
     * Scope a query to get records created since this week.
     */
    public function scopeSinceThisWeek(Builder $query): void
    {
        $query->since(Interval::WEEK);
    }

    /**
     * Scope a query to get records created since this month.
     */
    public function scopeSinceThisMonth(Builder $query): void
    {
        $query->since(Interval::MONTH);
    }
}
