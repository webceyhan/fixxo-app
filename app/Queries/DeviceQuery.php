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
                // 'name',
                // 'brand',
                // 'type',
                // 'status',
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
     * Get all distinct brands sorted by their frequency.
     */
    public static function brands(): Builder
    {
        return Device::query()
            ->select('brand')
            ->whereNotNull('brand')
            ->groupBy('brand')
            ->orderByRaw('COUNT(brand) DESC');
    }

    /**
     * Get the filters for the query UI.
     */
    public static function filters(): array
    {
        return [
            'status' => [
                'options' => DeviceStatus::values(),
                'default' => DeviceStatus::CHECKED_IN,
            ],
            'type' => [
                'options' => DeviceType::values(),
            ],
            'brand' => [
                'options' => self::brands()->pluck('brand'),
            ]
        ];
    }
}
