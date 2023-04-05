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
        // skip if no keyword is given
        if (empty($keyword)) return;

        // issue: value is "Kelly Muller DVM", keyword 'dvm' is working but vm is not
        // but if you begin with 'k', 'ke', 'kel', 'kell' or 'kelly' it works!

        // @todo: minimum length of keyword (between ) must be 3 characters (mysql default)
        // @see: mysql config "innodb_ft_min_token_size"
        // @see: https://dev.mysql.com/doc/refman/8.0/en/innodb-parameters.html#sysvar_innodb_ft_min_token_size

        // append * to each word to do wildcard search
        $keyword = addslashes(implode('* ', explode(' ', $keyword)) . '*');

        // create full-text statement in boolean mode
        $statement = "MATCH({$this->index()}) AGAINST ('$keyword' IN BOOLEAN MODE)";

        $query
            ->select('*') // bugfix: must select all with selectRaw()
            ->selectRaw("$statement AS score")
            ->whereRaw("($statement)")
            ->orderByDesc('score');
    }

    /**
     * Get the full-text index using the searchable attributes.
     */
    private function index(): string
    {
        return  implode(',', $this->searchable ?? []);
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
