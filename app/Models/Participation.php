<?php

namespace App\Models;

use App\Models\Traits\HasFilter;
use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory,
        HasFilter,
        UsesUuid;

    protected $guarded = [];

    public function scopeFilter(Builder $query, array $filters)
    {
        return $query->when($filters['search'] ?? null, function (Builder $query, $search) {
            return $query->whereHas('event', function ($query) use ($search) {
                return $query->where('name', 'LIKE', '%' . $search . '%');
            })->orWhereHas('user', function ($query) use ($search) {
                return $query->where('name', 'LIKE', '%' . $search . '%');
            });
        })->when($filters['status'] ?? null, function (Builder $query, $status) {
            return $query->where('status', $status);
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
