<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Resources\Event\EventCollection;
use App\Http\Resources\Event\EventResource;
use App\Models\Event;
use App\Models\EventType;
use App\Services\Event\EventService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
        $this->authorize('view-events', Event::class);

        $filters = $request->only(['search', 'status']);

        return Inertia::render('Events/Index', [
            'filters' => $filters,
            'events' => new EventCollection(
                auth()->user()->events()
                    ->with(['eventType'])
                    ->filter($filters)
                    ->paginate()
            )
        ]);
    }

    public function create()
    {
        $this->authorize('create-event', Event::class);

        return Inertia::render('Events/Create', [
            'eventTypes' => EventType::pluck('name', 'id')
        ]);
    }

    public function store(StoreEventRequest $request)
    {
        $this->eventService->store($request);

        return redirect()
            ->route('events.index')
            ->with('success', 'An event has been created');
    }

    public function show(Event $event)
    {
        $this->authorize('show-event', Event::class);

        return Inertia::render('Events/Show', [
            'event' => new EventResource(
                $event->load(['eventPictures', 'user', 'eventInformations'])
            )
        ]);
    }

    public function edit(Event $event)
    {
        $this->authorize('edit-event', Event::class);

        return Inertia::render('Events/Edit', [
            'event' => new EventResource(
                $event->load(['eventType'])
            ),
            'eventTypes' => EventType::pluck('name', 'id'),
            'eventInformations' => $event->eventInformations()
                ->pluck('information')
                ->implode(',')
        ]);
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->eventService->update($request, $event);

        return redirect()
            ->route('events.show', $event->id)
            ->with('success', 'Event has been updated');
    }

    public function destroy(Event $event)
    {
        $this->eventService->delete($event);

        return redirect()
            ->route('events.index')
            ->with('success', 'An event has been deleted');
    }

    public function changeStatus(Event $event)
    {
        $response = $this->eventService->changeStatus($event);

        return redirect()
            ->route('events.index')
            ->with('success', $response);
    }

    public function limitEventPicture(Event $event)
    {
        $limit = 5 - $event->eventPictures()->count();

        return response()
            ->json([
                'message' => 'Successful',
                'data' => [
                    'limit' => $limit
                ]
            ], 200);
    }
}
