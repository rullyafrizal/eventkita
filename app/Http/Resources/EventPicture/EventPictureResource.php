<?php

namespace App\Http\Resources\EventPicture;

use App\Enums\DateFormat;
use App\Http\Resources\Event\EventResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventPictureResource extends JsonResource
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
            'path' => photo_url($this->path),
            'event' => new EventResource($this->whenLoaded('event')),
            'active' => false,
            'file' => file_responses($this->path),
            'created_at' => $this->created_at->format(DateFormat::WITH_TIME),
            'updated_at' => $this->updated_at->format(DateFormat::WITH_TIME),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->format(DateFormat::WITH_TIME) : null,
        ];
    }
}
