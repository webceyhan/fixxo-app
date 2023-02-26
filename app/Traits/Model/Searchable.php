<?php

namespace App\Traits\Model;

use Illuminate\Database\Eloquent\Builder;

/**
 * Extend Eloquent models with the ability to do full text search.
 */
trait Searchable
{


    // LOCAL SCOPES ////////////////////////////////////////////////////////////////////////////////

    /**
     * Scope a query to only include records matching
     * given keyword against predefined fulltext index.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $keyword
     * @param string $index
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function scopeMatchAgainst(Builder $query, string $keyword, string $index)
    {
        // issue: value is "Kelly Muller DVM", keyword 'dvm' is working but vm is not
        // but if you begin with 'k', 'ke', 'kel', 'kell' or 'kelly' it works!

        // @todo: minimum length of keyword (between ) must be 3 characters (mysql default)
        // @see: mysql config "innodb_ft_min_token_size"
        // @see: https://dev.mysql.com/doc/refman/8.0/en/innodb-parameters.html#sysvar_innodb_ft_min_token_size

        // append * to each word to do wildcard search
        $keyword = addslashes(implode('* ', explode(' ', $keyword)) . '*');

        // create fulltext statement in boolean mode
        $statement = "MATCH($index) AGAINST ('$keyword' IN BOOLEAN MODE)";

        return $query
            ->select('*') // bugfix: must select all with selectRaw()
            ->selectRaw("$statement AS score")
            ->whereRaw("($statement)")
            ->orderByDesc('score');
    }

    /**
     * Scope a query to only include records matching
     * given keyword against predefined fulltext index.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function scopeSearchBy(Builder $query, string $keyword)
    {
        // search by id if keyword is numeric
        if (is_numeric($keyword)) {
            return $query->where('id', (int)$keyword);
        }

        // search by fulltext index matching
        return $query->matchAgainst($keyword, $this->searchIndex);
    }


    /**
     * Scope a query to filter records by given parameters (if available)
     * which correspond to model's filterable attributes definition.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function scopeFilterByParams(Builder $query, array $params = [])
    {
        foreach ($params as $key => $value) {

            if ($key === 'search') {
                $query->when($value, fn ($query, $value) => $query->searchBy($value));
                continue;
            }

            $query->when($value, fn ($query, $value) => $query->where($key, $value));
        }

        return $query;
    }
}
