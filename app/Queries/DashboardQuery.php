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

        $this->since(static::interval());
    }

    // PARTIAL QUERIES /////////////////////////////////////////////////////////////////////////////

    /**
     * Get the query for recent tickets for the dashboard.
     */
    public static function recentTickets()
    {
        return (new self(Ticket::query()))
            ->with([
                'device',
                'customer'
            ])
            ->latest()
            ->limit(5);
    }

    /**
     * Generate chart data for the given query.
     */
    public static function chartDataFor(Builder $query): array
    {
        $result = (new self($query))
            ->selectRaw(self::intervalFx() . '(created_at) AS label')
            ->selectRaw('COUNT(id) AS value')
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        return [
            'labels' => $result->pluck('label'),
            'values' => $result->pluck('value'),
            'value' => $result->sum('value'),
        ];
    }

    // HELPERS /////////////////////////////////////////////////////////////////////////////////////

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

    /**
     * Get the interval for the query.
     */
    private static function interval(): string
    {
        return request('interval', Interval::DAY);
    }

    /**
     * Get the mysql function for interval.
     */
    private static function intervalFx(): string
    {
        return [
            Interval::DAY => 'hour',
            Interval::WEEK => 'day',
            Interval::MONTH => 'week',
            Interval::YEAR => 'month',
        ][static::interval()];
    }
}
