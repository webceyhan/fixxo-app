<?php

namespace App\Queries;

use App\Enums\DeviceStatus;
use App\Models\Device;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DeviceQuery extends QueryBuilder
{
    public function __construct(?Builder $baseQuery = null)
    {
        parent::__construct($baseQuery ?? Device::query());

        $this
            ->allowedSorts([
                'name',
                'brand',
                'type',
                'status',
                'created_at',
            ])
            ->allowedFilters([
                AllowedFilter::scope('search'),
                AllowedFilter::exact('brand'),
                AllowedFilter::exact('type'),
                AllowedFilter::exact('status')->default(DeviceStatus::CHECKED_IN)
            ])
            ->defaultSort('-created_at')
            ->with([
                'customer:id,name'
            ]);
    }
}
