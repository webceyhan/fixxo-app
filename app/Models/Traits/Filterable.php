<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Filterable attributes.
     *
     * @var array<int, string>
     */
    // protected $filterable = [];

    /**
     * Scope a query to only include records matching given filters.
     */
    public function scopeFilter(Builder $query, array $params = []): void
    {
        foreach ($params as $key => $value) {
            // skip if the given key is not allowed
            if (!$this->isAllowed($key)) continue;

            $query->where($key, $value);
        }
    }

    /**
     * Check if the given key is allowed to be filtered.
     */
    private function isAllowed(string $key): bool
    {
        return in_array($key, $this->filterable ?? []);
    }
}
