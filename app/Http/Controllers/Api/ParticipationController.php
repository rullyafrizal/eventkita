<?php

namespace App\Http\Controllers\Api;

use App\Enums\HttpStatus;
use App\Enums\ParticipationStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Participation\ParticipationCollection;
use App\Models\Event;
use App\Models\Participation;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{
    public function index()
    {
        $participations = new ParticipationCollection(
            auth()->user()
                ->participations()
                ->orderByDesc('created_at')
                ->with(
                    [
                        'event' => function ($query) {
                            return $query->with(['eventPictures', 'user', 'participations'])
                                ->withCount(['participations']);
                        }
                    ]
                )
                ->get()
        );

        return api_response(
            HttpStatus::OK,
            'Success fetching participations',
            $participations
        );
    }

    public function present(Participation $participation)
    {
        if ($participation->user_id == auth()->id()) {
            $participation->update([
                'status' => ParticipationStatus::PRESENT
            ]);

            return api_response(
                HttpStatus::OK,
                'Success present'
            );
        }

        abort(403, 'Unauthorized');
    }

    public function checkJoined(Event $event)
    {
        $joined = false;

        $participation = Participation::query()
            ->where('user_id', auth('sanctum')->id())
            ->where('event_id', $event->id)
            ->get();

        if (count($participation)) {
            $joined = true;
        }

        return api_response(
            HttpStatus::OK,
            'Success checking joined status',
            [
                'participations' => $participation,
                'joined' => $joined
            ]
        );
    }
}
