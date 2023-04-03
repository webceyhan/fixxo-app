<?php

namespace App\Queries;

use App\Enums\Interval;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

class DashboardQuery extends QueryBuilder
{
    public function __construct(?Builder $baseQuery = null)
    {
        parent::__construct($baseQuery);

        $this->since(static::interval())->latest();
    }

    /**
     * Get the interval for the query.
     */
    public static function interval(): string
    {
        return request('interval', Interval::DAY);
    }



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
                'value' => static::interval(),
                'default' => Interval::DAY,
            ]
        ];
    }

    // PARTIAL QUERIES /////////////////////////////////////////////////////////////////////////////
    
    public static function recentTickets()
    {
        return (new self(Ticket::query()))
            ->with([
                'device',
                'customer'
            ])
            ->limit(5);
    }
}
