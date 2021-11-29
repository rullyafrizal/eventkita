<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventInformation extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $guarded = [];

    protected $table = 'event_informations';

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
