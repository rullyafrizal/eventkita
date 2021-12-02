<?php

namespace App\Models;

use App\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory,
        SoftDeletes,
        HasFilter;

    protected $casts = [
        'is_published' => 'boolean'
    ];

    public function scopeFilter(Builder $query, array $filters)
    {
        $query = $this->trashedFilter($query, $filters);

        return $query->when($filters['search'] ?? null, function (Builder $query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->when($filters['status'] ?? null, function (Builder $query, $status) {
            return $query->where('is_published', $status === 'published');
        });
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function scopeWherePublished(Builder $query)
    {
        return $query->where('is_published', true);
    }
}
