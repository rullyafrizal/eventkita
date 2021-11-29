<?php

namespace App\Models;

use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Builder, Model, SoftDeletes};

class EventPicture extends Model
{
    use HasFactory,
        SoftDeletes,
        UsesUuid;

    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function scopeFilter(Builder $query, array $filters) {
        return $query->when($filters['search'] ?? null, function (Builder $query, $search) {
            return $query->whereHas('event', function ($query) use ($search) {
                return $query->where('name', 'LIKE', '%' . $search . '%');
            });
        });
    }
}
