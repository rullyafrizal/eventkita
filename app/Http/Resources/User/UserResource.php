<?php

namespace App\Http\Resources\User;

use App\Enums\DateFormat;
use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Event\EventCollection;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'roles_by_name' => $this->roles->pluck('name'),
            'participants_count' => $this->whenLoaded('eventParticipants', function () {
                return $this->event_participants_count;
            }, 0),
            'created_at' => $this->created_at->format(DateFormat::WITH_TIME),
            'updated_at' => $this->updated_at->format(DateFormat::WITH_TIME),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->format(DateFormat::WITH_TIME) : null,
        ];
    }
}
