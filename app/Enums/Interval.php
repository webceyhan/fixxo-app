<?php

namespace App\Enums;

use App\Enums\Concerns\Collectable;
use Carbon\Carbon;

enum Interval: string
{
    use Collectable;

    case Day = 'day';
    case Week = 'week';
    case Month = 'month';
    case Year = 'year';

    /**
     * Convert the interval to a Carbon date formatter.
     */
    public function toDateFormatter(): callable
    {
        return match ($this) {
            self::Day => fn ($date) => Carbon::today()->setTime($date, 0, 0)->format('H:i'),
            self::Week => fn ($date) => Carbon::today()->day($date)->format('D'),
            self::Month => fn ($date) => Carbon::today()->week($date)->format('d M'),
            self::Year => fn ($date) => Carbon::today()->month($date)->format('M'),
            default => fn ($date) => $date,
        };
    }

    /**
     * Convert the interval to a SQL function.
     */
    public function toSqlFunction(): string
    {
        return match ($this) {
            self::Day => 'hour',
            self::Week => 'day',
            self::Month => 'week',
            self::Year => 'month',
            default => 'year',
        };
    }

    /**
     * Get interval options for the dashboard.
     */
    public static function options(): array
    {
        return [
            self::Day->value => 'Today',
            self::Week->value => 'This Week',
            self::Month->value => 'This Month',
            self::Year->value => 'This Year',
        ];
    }
}
