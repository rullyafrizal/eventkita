<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    /**
     * Global trashed filter builder
     *
     * @param Builder $query
     * @param $filters
     * @return \Illuminate\Database\Concerns\BuildsQueries|Builder|mixed
     */
    public function trashedFilter(Builder $query, $filters)
    {
        return $query->when($filters['trashed'] ?? null, function (Builder $query, $trashed) {
            return $query->{$trashed . 'Trashed'}();
        });
    }
}
