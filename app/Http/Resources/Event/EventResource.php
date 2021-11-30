<?php

namespace App\Http\Resources\Event;

use App\Enums\DateFormat;
use App\Http\Resources\EventInformation\EventInformationCollection;
use App\Http\Resources\EventPicture\EventPictureCollection;
use App\Http\Resources\EventType\EventTypeResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'description' => $this->description,
            'quota' => $this->quota,
            'status' => $this->status,
            'start_date' => $this->start_date->format(DateFormat::DAY_DATE_TIME),
            'end_date' => $this->end_date->format(DateFormat::DAY_DATE_TIME),
            'real_start_date' => $this->start_date,
            'real_end_date' => $this->end_date,
            'event_type' => new EventTypeResource($this->whenLoaded('eventType')),
            'pictures' => new EventPictureCollection($this->whenLoaded('eventPictures')),
            'informations' => new EventInformationCollection($this->whenLoaded('eventInformations')),
            'participant_count' => $this->whenLoaded('participations', function() {
                return $this->participant_count;
            }, 0),
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at->format(DateFormat::WITH_TIME),
            'updated_at' => $this->updated_at->format(DateFormat::WITH_TIME),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->format(DateFormat::WITH_TIME) : null,
        ];
    }
}
