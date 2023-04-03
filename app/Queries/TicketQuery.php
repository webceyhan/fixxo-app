<?php

namespace App\Queries;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TicketQuery extends QueryBuilder
{
    public function __construct(?Builder $baseQuery = null)
    {
        parent::__construct($baseQuery ?? Ticket::query());

        $this
            ->allowedSorts([
                'status',
                'created_at',
            ])
            ->allowedFilters([
                AllowedFilter::scope('search'),
                AllowedFilter::exact('status'),
                AllowedFilter::scope('overdue'),
                AllowedFilter::scope('outstanding'),
            ])
            ->defaultSort('-created_at')
            ->with([
                'device',
            ]);
    }
}
