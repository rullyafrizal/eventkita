<?php

namespace App\Services\Event;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\EventInformation;
use App\Models\EventPicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventService
{
    public function store(Request $request)
    {
        DB::transaction(function() use ($request) {
            $event = Event::query()
                ->create([
                    'name' => $request->name,
                    'location' => $request->location,
                    'quota' => $request->quota,
                    'description' => $request->description,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'status' => EventStatus::CLOSED,
                    'event_type_id' => $request->event_type,
                    'user_id' => auth()->id(),
                ]);

            $event_informations = explode(",", $request->event_informations);

            foreach($event_informations as $event_information) {
                EventInformation::query()
                    ->create([
                        'information' => trim($event_information),
                        'event_id' => $event->id
                    ]);
            }

            foreach($request->event_pictures as $event_picture) {
                $this->storePicture($event, $event_picture);
            }
        });
    }

    public function storePicture($event, $event_picture)
    {
        EventPicture::query()
            ->create([
                'path' => $event_picture['file'] ?
                    $event_picture['file'][0]['path'] : null,
                'event_id' => $event->id,
            ]);
    }

    public function changeStatus(Event $event)
    {
        $response = '';

        if($event->status == EventStatus::OPEN) {
            $event->update(['status' => EventStatus::CLOSED]);

            $response = 'An event has been closed';
        } else if ($event->status == EventStatus::CLOSED) {
            $event->update(['status' => EventStatus::OPEN]);

            $response = 'An event has been opened';
        }

        return $response;
    }

    public function update(Request $request, Event $event)
    {
        $event->update([
            'name' => $request->name,
            'location' => $request->location,
            'quota' => $request->quota,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'event_type_id' => $request->event_type,
            'user_id' => auth()->id(),
        ]);

        if ($request->event_informations) {
           $event_informations = explode(',', $request->event_informations);

            $event->eventInformations()->forceDelete();

           foreach ($event_informations as $event_information) {
               EventInformation::query()
                   ->create([
                       'information' => trim($event_information),
                       'event_id' => $event->id
                   ]);
           }
        } else {
            $event->eventInformations()->forceDelete();
        }
    }

    public function delete(Event $event)
    {
        DB::transaction(function () use ($event) {
            $event->eventPictures()
                ->each(function ($eventPicture) {
                    Storage::disk('local')->delete($eventPicture->path);
                });

            $event->participations()->forceDelete();

            $event->eventInformations()->forceDelete();

            $event->eventPictures()->forceDelete();

            $event->forceDelete();
        });
    }
}
