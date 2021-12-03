<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventType\StoreEventTypeRequest;
use App\Http\Requests\EventType\UpdateEventTypeRequest;
use App\Http\Resources\EventType\EventTypeCollection;
use App\Http\Resources\EventType\EventTypeResource;
use App\Models\EventType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventTypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view-event-types');
    }

    public function index(Request $request)
    {
        $filters = $request->only(['trashed', 'search']);

        return Inertia::render('EventTypes/Index', [
            'filters' => $filters,
            'eventTypes' => new EventTypeCollection(
                EventType::query()
                    ->orderBy('name')
                    ->filter($filters)
                    ->paginate(5)
            )
        ]);
    }

    public function create()
    {
        $this->authorize('create-event-type', EventType::class);

        return Inertia::render('EventTypes/Create');
    }

    public function store(StoreEventTypeRequest $request)
    {
        EventType::query()->create([
            'name' => $request->name
        ]);

        return redirect()
            ->route('event-types.index')
            ->with('success', 'An event type has been created');
    }

    public function edit(EventType $eventType)
    {
        $this->authorize('edit-event-type');

        return Inertia::render('EventTypes/Edit', [
            'eventType' => new EventTypeResource($eventType)
        ]);
    }

    public function update(UpdateEventTypeRequest $request, EventType $eventType)
    {
        $eventType->update([
            'name' => $request->name
        ]);

        return redirect()
            ->route('event-types.edit', $eventType->id)
            ->with('success', 'An event type has been updated');
    }

    public function destroy(EventType $eventType)
    {
        $this->authorize('delete-event-type');

        $eventType->delete();

        return redirect()
            ->route('event-types.index')
            ->with('success', 'An event type has been deleted');
    }

    public function restore(EventType $eventType)
    {
        $this->authorize('restore-event-type');

        $eventType->restore();

        return redirect()
            ->route('event-types.index')
            ->with('success', 'An event type has been deleted');
    }
}
