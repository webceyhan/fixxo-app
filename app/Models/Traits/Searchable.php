<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Extend Eloquent models with the ability to do full-text search.
 *
 * @static \Illuminate\Database\Eloquent\Builder searchBy(string $keyword)
 * @static \Illuminate\Database\Eloquent\Builder filterByParams(array $params)
 * @static \Illuminate\Database\Eloquent\Builder matchAgainst(string $keyword, string $index)
 */
trait Searchable
{
    /**
     * Index to use for full-text search.
     *
     * @var string
     */
    // protected $searchIndex = '';

    public static function fullTextColumns(): array
    {
        // get the search index definition from model
        $searchIndex = (new static)->searchIndex;

        // convert it to an array
        return explode(',', $searchIndex);
    }

    /**
     * Scope a query to only include records by full-text search
     * matching given keyword against full-text index.
     */
    public function scopeMatchAgainst(Builder $query, string $keyword, string $index): void
    {
        // issue: value is "Kelly Muller DVM", keyword 'dvm' is working but vm is not
        // but if you begin with 'k', 'ke', 'kel', 'kell' or 'kelly' it works!

        // @todo: minimum length of keyword (between ) must be 3 characters (mysql default)
        // @see: mysql config "innodb_ft_min_token_size"
        // @see: https://dev.mysql.com/doc/refman/8.0/en/innodb-parameters.html#sysvar_innodb_ft_min_token_size

        // append * to each word to do wildcard search
        $keyword = addslashes(implode('* ', explode(' ', $keyword)) . '*');

        // create full-text statement in boolean mode
        $statement = "MATCH($index) AGAINST ('$keyword' IN BOOLEAN MODE)";

        $query
            ->select('*') // bugfix: must select all with selectRaw()
            ->selectRaw("$statement AS score")
            ->whereRaw("($statement)")
            ->orderByDesc('score');
    }

    /**
     * Scope a query to only include records matching
     * given keyword against predefined search index in model.
     */
    public function scopeSearchBy(Builder $query, string $keyword): void
    {
        if (is_numeric($keyword)) {
            // search by id if keyword is numeric
            $query->where('id', (int)$keyword);
        } else {
            // or perform a full-text search
            $query->matchAgainst($keyword, $this->searchIndex);
        }
    }

    /**
     * Scope a query to filter records by given parameters (if available)
     * which correspond to model's filterable attributes definition.
     */
    public function scopeFilterByParams(Builder $query, array $params = []): void
    {
        foreach ($params as $key => $value) {

            if ($key === 'search') {
                $query->when($value, fn ($query, $value) => $query->searchBy($value));
                continue;
            }

            $query->when($value, fn ($query, $value) => $query->where($key, $value));
        }
    }
}
