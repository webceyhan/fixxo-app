<?php

namespace App\Queries;

use App\Enums\OrderStatus;
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
                // 'status',
                'created_at',
            ])
            ->allowedFilters([
                AllowedFilter::scope('search'),
                AllowedFilter::exact('status')->default(OrderStatus::New),
            ])
            ->defaultSort('-created_at')
            ->with([
                'ticket.device',
                'ticket.customer',
            ]);
    }

    /**
     * Get the filters for the query UI.
     */
    public static function filters(): array
    {
        return [
            'status' => [
                'options' => OrderStatus::values(),
                'default' => OrderStatus::New
            ]
        ];
    }
}
