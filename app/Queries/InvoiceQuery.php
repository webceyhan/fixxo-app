<?php

namespace App\Queries;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class InvoiceQuery extends QueryBuilder
{
    public function __construct(?Builder $baseQuery = null)
    {
        parent::__construct($baseQuery ?? Invoice::query());

        $this
            ->allowedSorts([
                // 'status',
                'created_at',
                'due_date',
            ])
            ->allowedFilters([
                AllowedFilter::callback('search', function (Builder $query, $value) {
                    // TODO: implement better search
                    $query->whereHas('ticket.customer', fn(Builder $query) => $query->search($value));
                }),
                // AllowedFilter::scope('search'),
                AllowedFilter::scope('unpaid'),
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
            // 'status' => [
            //     'options' => InvoiceStatus::values(),
            //     'default' => InvoiceStatus::New
            // ]
        ];
    }
}
