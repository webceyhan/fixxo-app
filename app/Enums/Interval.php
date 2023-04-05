<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;

enum Interval: string
{
    use HasBase;

    case DAY = 'day';
    case WEEK = 'week';
    case MONTH = 'month';
    case YEAR = 'year';

    /**
     * Convert given interval to date.
     */
    public function toDate(): \Carbon\Carbon
    {
        $date = \Carbon\Carbon::today();

        switch ($this) {
            case self::DAY:
                return $date->subDay();

            case self::WEEK:
                return $date->subWeek();

            case self::MONTH:
                return $date->subMonth();

            case self::YEAR:
                return $date->subYear();

            default:
                return $date->subCentury();
        }
    }
}
