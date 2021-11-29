<?php

namespace App\Models;

use App\Models\Traits\HasFilter;
use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory,
        HasFilter,
        UsesUuid;

    protected $guarded = [];
}
