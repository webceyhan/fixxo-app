<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;
use Carbon\Carbon;

enum Interval: string
{
    use HasBase;

    case DAY = 'day';
    case WEEK = 'week';
    case MONTH = 'month';
    case YEAR = 'year';

    /**
     * Convert the interval to a Carbon date.
     */
    public function toDate(): Carbon
    {
        return match ($this) {
            self::DAY => Carbon::today()->subDay(),
            self::WEEK => Carbon::today()->subWeek(),
            self::MONTH => Carbon::today()->subMonth(),
            self::YEAR => Carbon::today()->subYear(),
            default => Carbon::today()->subCentury(),
        };
    }

    /**
     * Convert the interval to a SQL function.
     */
    public function toSqlFunction(): string
    {
        return match ($this) {
            self::DAY => 'hour',
            self::WEEK => 'day',
            self::MONTH => 'week',
            self::YEAR => 'month',
            default => 'year',
        };
    }
}
