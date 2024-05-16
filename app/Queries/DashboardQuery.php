<?php

namespace App\Queries;

use App\Enums\Interval;
use App\Enums\TaskStatus;
use App\Enums\TicketStatus;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\Transaction;
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
    public static function recentTickets(): self
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
    public static function chartDataFor(Builder $query, bool $count = true): array
    {
        $result = (new self($query))
            ->selectRaw(self::interval()->toSqlFunction() . '(created_at) AS label')
            ->when($count, fn ($q) => $q->selectRaw('COUNT(id) AS value'))
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        return [
            'labels' => $result->pluck('label'),
            'values' => $result->pluck('value'),
            'value' => $result->sum('value'),
        ];
    }

    /**
     * Generate chart data for income stats.
     */
    public static function chartDataForIncome()
    {
        $query = Task::query()->selectRaw('SUM(cost) AS value');

        $data = self::chartDataFor($query, false);

        return [
            ...$data,
            'labels' => $data['labels']->map(self::interval()->toDateFormatter()),
        ];
    }

    /**
     * Get ticket stats for the dashboard.
     */
    public static function ticketStats(): array
    {
        $query = Ticket::query()
            ->selectRaw('COUNT(id) AS value, status AS label')
            ->whereNot('status', TicketStatus::Closed);

        return self::statsFor($query);
    }

    /**
     * Get task stats for the dashboard.
     */
    public static function taskStats(): array
    {
        $query = Task::query()
            ->selectRaw(
                'IF(completed_at IS NULL, "'
                    . TaskStatus::Pending->value . '", "'
                    . TaskStatus::Completed->value . '") AS label'
            );

        return self::statsFor($query);
    }

    /**
     * Get earning stats for the dashboard.
     */
    public static function earningStats(): array
    {
        return [
            [
                'label' => 'expected',
                'value' => (new self(Task::query()))->sum('cost')
            ],
            [
                'label' => 'received',
                'value' => (new self(Transaction::query()))->sum('amount')
            ]
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
                'value' => static::interval(),
                'options' => Interval::options(),
            ]
        ];
    }

    /**
     * Get the requested interval.
     */
    private static function interval(): Interval
    {
        return Interval::tryFrom(request('interval')) ?? Interval::Week;
    }

    /**
     * Get the label-value pairs for the given query.
     * 
     * Example structure:
     *     label        |   value
     *     -------------+-----------
     *     pending      |   1
     *     completed    |   2
     */
    private static function statsFor(Builder $query): array
    {
        return (new self($query))
            ->selectRaw('COUNT(id) AS value')
            // label has to be provided by the query
            ->groupBy('label')
            ->orderByDesc('label')
            ->get()
            ->toArray();
    }
}
