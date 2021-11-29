<?php

namespace App\Http\Resources\EventInformation;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EventInformationCollection extends ResourceCollection
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
            'data' => EventInformationResource::collection($this->collection)
        ];
    }
}
