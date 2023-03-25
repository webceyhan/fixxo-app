<?php

namespace App\Enums;

class Interval extends Enum
{
    const DAY = 'day';
    const WEEK = 'week';
    const MONTH = 'month';
    const YEAR = 'year';

    /**
     * Convert given interval to date.
     */
    public static function toDate(string $value): \Carbon\Carbon
    {
        $date = \Carbon\Carbon::today();

        switch ($value) {
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
