<?php

namespace App\Http\Controllers\Api;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Event\EventCollection;
use App\Http\Resources\Event\EventResource;
use App\Models\Event;
use App\Services\Api\ApiEventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $paginate = $request->paginate ? (float)$request->paginate : 6;

        return api_response(
            HttpStatus::OK,
            'Success fetching events',
            new EventCollection(
                Event::query()
                    ->with(['eventPictures', 'participations'])
                    ->withCount('participations')
                    ->orderByDesc('created_at')
                    ->whereOpen()
                    ->paginate($paginate)
            )
        );
    }

     public function indexPagination(Request $request)
     {
          $paginate = $request->paginate ? (float)$request->paginate : 6;

          $filters = $request->only(['type', 'search']);
          $filters['type'] = array_key_exists('type', $filters) ?
              explode(',', $filters['type']) : [];

          return new EventCollection(
              Event::query()
                  ->with(['eventPictures', 'participations', 'eventType'])
                  ->filter($filters)
                  ->withCount('participations')
                  ->orderByDesc('created_at')
                  ->whereOpen()
                  ->paginate($paginate)
          );
     }

    public function show(Event $event)
    {
        return api_response(
            HttpStatus::OK,
            'Success fetching event',
            new EventResource(
                $event->loadCount('participations')
                    ->load([
                        'eventInformations',
                        'eventPictures',
                        'eventType',
                        'participations',
                        'user' => function($query) {
                            return $query
                                ->with('eventParticipants')
                                ->withCount('eventParticipants as event_participants_count');
                        },
                    ])
            )
        );
    }

    public function join(Event $event, ApiEventService $service)
    {
        $response = $service->join($event, auth()->user());

        return !array_key_exists('body', $response) ?
            api_response($response['status'], $response['message']) :
            api_response($response['status'], $response['message'], $response['body']);
    }
}
