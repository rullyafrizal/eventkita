<?php

namespace App\Http\Controllers;

use App\Actions\UploadFile;
use App\Http\Requests\EventPicture\StoreEventPictureRequest;
use App\Http\Requests\EventPicture\UpdateEventPictureRequest;
use App\Http\Requests\EventPicture\UploadPictureRequest;
use App\Http\Resources\EventPicture\EventPictureCollection;
use App\Http\Resources\EventPicture\EventPictureResource;
use App\Models\Event;
use App\Models\EventPicture;
use App\Services\Event\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EventPictureController extends Controller
{
    /**
     * @param Request $request
     * @return \Inertia\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view-event-pictures', EventPicture::class);

        $filters = $request->only(['search']);

        return Inertia::render('EventPictures/Index', [
            'filters' => $filters,
            'eventPictures' => new EventPictureCollection(
                EventPicture::query()
                    ->with('event')
                    ->whereHas('event', function ($query) {
                        return $query->where('user_id', auth()->id());
                    })
                    ->filter($filters)
                    ->paginate()
            )
        ]);
    }

    public function create()
    {
        $this->authorize('create-event-picture', EventPicture::class);

        return Inertia::render('EventPictures/Create', [
            'events' => auth()->user()
                ->events()
                ->withCount('eventPictures')
                ->having('event_pictures_count', '<', 5)
                ->pluck('name', 'id'),
        ]);
    }

    public function store(StoreEventPictureRequest $request, EventService $eventService)
    {
        foreach ($request->event_pictures as $event_picture) {
            $eventService->storePicture(Event::find($request->events), $event_picture);
        }

        return redirect()
            ->route('event-pictures.index')
            ->with('success', 'Event Pictures has been created');
    }

    /**
     * @param EventPicture $eventPicture
     * @return \Inertia\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(EventPicture $eventPicture)
    {
        $this->authorize('edit-event-picture', EventPicture::class);

        return Inertia::render('EventPictures/Edit', [
            'eventPicture' => new EventPictureResource($eventPicture)
        ]);
    }

    /**
     * @param UpdateEventPictureRequest $request
     * @param EventPicture $eventPicture
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(UpdateEventPictureRequest $request, EventPicture $eventPicture)
    {
        DB::transaction(function () use ($request, $eventPicture) {
           $eventPicture->update([
               'path' => $request->event_picture_file ?
                   $request->event_picture_file[0]['path'] : null
           ]);

           if ($eventPicture->path && !$request->event_picture_file) {
               Storage::disk('local')->delete($eventPicture->path);
           }
        });

        return redirect()
            ->route('event-pictures.index')
            ->with('success', 'Event picture has been updated');
    }

    /**
     * @param EventPicture $eventPicture
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function destroy(EventPicture $eventPicture)
    {
        $this->authorize('delete-event-picture', EventPicture::class);

        DB::transaction(function () use ($eventPicture) {
           Storage::disk('local')->delete($eventPicture->path);

           $eventPicture->forceDelete();
        });

        return redirect()
            ->route('event-pictures.index')
            ->with('success', 'Event picture has been deleted');
    }

    /**
     * @param UploadPictureRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(UploadPictureRequest $request)
    {
        $new_path = UploadFile::run($request);

        return response()->json([
            'url' => photo_url($new_path),
            'path' => $new_path,
        ]);
    }
}
