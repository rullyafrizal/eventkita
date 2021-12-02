<?php

namespace App\Services\Api;

use App\Enums\HttpStatus;
use App\Models\Event;
use App\Models\Participation;
use App\Models\User;

class ApiEventService
{
    public function join(Event $event, User $user): array
    {
        $participation = Participation::query()
            ->where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->first();

        if ($participation) {
            return [
                'status' => HttpStatus::OK,
                'message' => 'User already joined',
            ];
        }

        $participation = Participation::query()
            ->create([
                'event_id' => $event->id,
                'user_id' => $user->id,
            ]);

        return [
            'status' => HttpStatus::OK,
            'message' => 'Success join event',
            'body' => $participation
        ];
    }
}
