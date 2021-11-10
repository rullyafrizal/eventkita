<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes
};

class EventPicture extends Model
{
    use HasFactory,
        SoftDeletes;
}
