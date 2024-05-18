<?php

namespace App\Queries;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserQuery extends QueryBuilder
{
    public function __construct(?Builder $baseQuery = null)
    {
        parent::__construct($baseQuery ?? User::query());

        $this
            ->allowedSorts([
                // 'name',
                // 'email',
                // 'role',
                // 'status',
                'created_at',
            ])
            ->allowedFilters([
                // 'name',
                // 'email',
                AllowedFilter::scope('search'),
                AllowedFilter::exact('role'),
                AllowedFilter::exact('status')->default(UserStatus::Active)
            ])
            ->defaultSort('-created_at')
            ->withCount([
                'assignedTickets',
            ]);
    }

    /**
     * Get the filters for the query UI.
     */
    public static function filters(): array
    {
        return [
            'status' => [
                'options' => UserStatus::values(),
                'default' => UserStatus::Active,
            ],
            'role' => [
                'options' => UserRole::values(),
            ],
        ];
    }
}
