<?php

namespace App\Queries;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerQuery extends QueryBuilder
{
    public function __construct(?Builder $baseQuery = null)
    {
        parent::__construct($baseQuery ?? Customer::query());

        $this
            ->allowedSorts([
                // 'name',
                // 'email',
                // 'status',
                'created_at',
            ])
            ->allowedFilters([
                // 'name',
                // 'email',
                AllowedFilter::scope('search'),
            ])
            ->defaultSort('-created_at')
            ->withCount([
                'devices',
                'tickets',
            ]);
    }

    /**
     * Get the filters for the query UI.
     */
    public static function filters(): array
    {
        return [];
    }
}
