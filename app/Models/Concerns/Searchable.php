<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Builder|static search(?string $keyword)
 */
trait Searchable
{
    /**
     * Searchable attributes.
     *
     * @var array<int, string>
     */
    // protected $searchable = [];

    /**
     * Get the full-text index columns.
     * This is used to create the full-text index in the migration.
     */
    public static function fullTextColumns(): array
    {
        return (new static)->searchable ?? [];
    }

    // SCOPES //////////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include models matching given keyword.
     */
    public function scopeSearch(Builder $query, ?string $keyword): void
    {
        if (empty($keyword)) {
            return;
        }

        $fuzzyKeyword = addslashes(implode('* ', explode(' ', $keyword)) . '*');

        $query->whereFullText($this->searchable, $fuzzyKeyword, ['mode' => 'boolean']);
    }
}
