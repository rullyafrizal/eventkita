<?php

namespace App\Http\Controllers\Api;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventType\EventTypeCollection;
use App\Models\EventType;
use Illuminate\Http\Request;

class EventTypeController extends Controller
{
    public function index()
    {
        return api_response(
            HttpStatus::OK,
            'Success fetching event types',
            ['event_types' => EventType::pluck('name')]
        );
    }
}
