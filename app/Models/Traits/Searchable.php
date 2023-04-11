<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    // protected $searchable = [];

    /**
     * Scope a query to only include records matching
     * given keyword against searchable model attributes.
     */
    public function scopeSearch(Builder $query, ?string $keyword = null): void
    {
        // skip if keyword is empty
        if (empty($keyword)) return;

        // append * wildcard to each word to do fuzzy search
        $keyword = addslashes(implode('* ', explode(' ', $keyword)) . '*');

        // create full-text search in boolean mode for searchable columns
        $query->whereFullText($this->searchable ?? [], $keyword, ['mode' => 'boolean']);
    }

    /**
     * Get the full-text index columns.
     * This is used to create the full-text index in the migration.
     */
    public static function fullTextColumns(): array
    {
        return (new static)->searchable ?? [];
    }
}
