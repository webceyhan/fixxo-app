<?php

namespace App\Queries;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrderQuery extends QueryBuilder
{
    public function __construct(?Builder $baseQuery = null)
    {
        parent::__construct($baseQuery ?? Order::query());

        $this
            ->allowedSorts([
                'status',
                'created_at',
            ])
            ->allowedFilters([
                AllowedFilter::scope('search'),
                AllowedFilter::exact('status'),
            ])
            ->defaultSort('-created_at')
            ->with([
                'ticket.device',
                'ticket.customer',
            ]);
    }
}
