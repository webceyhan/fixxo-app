<?php

namespace App\Queries;

use App\Enums\DeviceStatus;
use App\Enums\DeviceType;
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

    /**
     * Get the filters for the query UI.
     */
    public static function filters(): array
    {
        // Get all distinct brands to use as filter options
        $brands = Device::brands()->get();

        return [
            'status' => [
                'options' => DeviceStatus::values(),
                'default' => DeviceStatus::CHECKED_IN
            ],
            'type' => [
                'options' => DeviceType::values(),
            ],
            'brand' => [
                'options' => $brands->pluck('brand'),
            ]
        ];
    }
}
