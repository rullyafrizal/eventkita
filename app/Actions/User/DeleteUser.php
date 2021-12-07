<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteUser
{
    use AsAction;

    public function handle(User $user)
    {
        DB::transaction(function () use ($user) {
            $user->events()
                ->each(function ($event) {
                    $event->eventPictures()
                        ->each(function ($eventPicture) {
                            Storage::disk('public')->delete($eventPicture->path);
                        });

                    $event->eventPictures()->forceDelete();

                    $event->eventInformations()->forceDelete();
                });

            $user->participations()->forceDelete();

            $user->events()->forceDelete();

            $user->forceDelete();
        });
    }
}
