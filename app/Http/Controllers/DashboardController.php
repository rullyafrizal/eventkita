<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view-dashboard']);
    }

    public function index()
    {
        return Inertia::render('Dashboard/Index', [
            'usersCount' => User::query()
                ->whereNotIn('name', ['Admin'])
                ->count(),
            'eventsCount' => Event::query()
                ->count(),
            'newsCount' => News::query()
                ->count(),
            'userEventsCount' => auth()->user()
                ->events()
                ->count()
        ]);
    }
}
