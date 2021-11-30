<?php

namespace App\Http\Resources\Participation;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ParticipationCollection extends ResourceCollection
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
            'data' => ParticipationResource::collection($this->collection),
        ];
    }
}
