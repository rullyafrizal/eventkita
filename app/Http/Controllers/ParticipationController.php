<?php

namespace App\Http\Controllers;

use App\Http\Resources\Event\EventCollection;
use App\Http\Resources\Participation\ParticipationCollection;
use App\Models\Event;
use App\Models\Participation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ParticipationController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view-participations', Participation::class);

        $filters = $request->only(['search']);

        return Inertia::render('Participations/Index', [
            'filters' => $filters,
            'events' => new EventCollection(
                auth()->user()
                    ->events()
                    ->with('participations')
                    ->withCount('participations')
                    ->filter($filters)
                    ->paginate()
            )
        ]);
    }

    public function show(Request $request, Event $event)
    {
        $this->authorize('show-participation', Participation::class);

        $filters = $request->only(['status', 'search']);

        return Inertia::render('Participations/Show', [
            'filters' => $filters,
            'participations' => new ParticipationCollection(
                $event->participations()
                    ->with(['user', 'event'])
                    ->filter($filters)
                    ->paginate()
            ),
            'event' => $event
        ]);
    }
}
