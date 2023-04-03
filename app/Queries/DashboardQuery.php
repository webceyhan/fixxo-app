<?php

namespace App\Queries;

use App\Enums\Interval;
use Spatie\QueryBuilder\QueryBuilder;

class DashboardQuery extends QueryBuilder
{
    /**
     * Get the filters for the query UI.
     */
    public static function filters(): array
    {
        return [
            'interval' => [
                'options' => [
                    Interval::DAY => 'Today',
                    Interval::WEEK => 'This Week',
                    Interval::MONTH => 'This Month',
                    Interval::YEAR => 'This Year',
                ],
                'value' => request('interval', Interval::DAY),
                'default' => Interval::DAY,
            ]
        ];
    }
}
