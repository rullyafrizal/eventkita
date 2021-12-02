<?php

namespace App\Models;

use App\Enums\EventStatus;
use App\Models\Traits\HasFilter;
use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory,
        SoftDeletes,
        HasFilter,
        UsesUuid;

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $guarded = [];

    public function scopeFilter(Builder $query, array $filters)
    {
        $query = $this->trashedFilter($query, $filters);

        return $query->when($filters['search'] ?? null, function (Builder $query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('location', 'like', '%' . $search . '%');
        })->when($filters['status'] ?? null, function (Builder $query, $status) {
            return $query->where('status', $status);
        });
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function eventPictures()
    {
        return $this->hasMany(EventPicture::class);
    }

    public function eventInformations()
    {
        return $this->hasMany(EventInformation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function scopeWhereOpen(Builder $query)
    {
        return $query->where('status', EventStatus::OPEN);
    }
}
