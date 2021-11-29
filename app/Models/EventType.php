<?php

namespace App\Models;

use App\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventType extends Model
{
    use HasFactory,
        HasFilter,
        SoftDeletes;

    protected $guarded = [];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query = $this->trashedFilter($query, $filters);

        return $query->when($filters['search'] ?? null, function (Builder $query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }
}
