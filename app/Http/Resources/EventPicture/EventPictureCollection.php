<?php

namespace App\Http\Resources\EventPicture;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EventPictureCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => EventPictureResource::collection($this->collection),
        ];
    }
}
