<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventTypes = ['Vaksinasi', 'Konser', 'Webinar', 'Charity', 'Workshop', 'Seminar'];

        foreach ($eventTypes as $eventType) {
            EventType::query()->updateOrCreate([
                'name' => $eventType
            ]);
        }
    }
}
