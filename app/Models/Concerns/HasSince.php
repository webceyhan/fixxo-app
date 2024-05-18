<?php

namespace App\Models\Concerns;

use App\Enums\Interval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * @method static Builder|static since(Interval $interval)
 * @method static Builder|static sinceToday()
 * @method static Builder|static sinceThisWeek()
 * @method static Builder|static sinceThisMonth()
 */
trait HasSince
{
    // SCOPES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include models created since the given interval.
     */
    public function scopeSince(Builder $query, Interval $interval): void
    {
        $query->where('created_at', '>=', match ($interval) {
            Interval::Day => Carbon::today()->startOfDay(),
            Interval::Week => Carbon::today()->startOfWeek(),
            Interval::Month => Carbon::today()->startOfMonth(),
            Interval::Year => Carbon::today()->startOfYear(),
        });
    }

    /**
     * Scope a query to only include models created since today.
     */
    public function scopeSinceToday(Builder $query): void
    {
        $query->since(Interval::Day);
    }

    /**
     * Scope a query to only include models created since this week.
     */
    public function scopeSinceThisWeek(Builder $query): void
    {
        $query->since(Interval::Week);
    }

    /**
     * Scope a query to only include models created since this month.
     */
    public function scopeSinceThisMonth(Builder $query): void
    {
        $query->since(Interval::Month);
    }
}
