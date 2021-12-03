<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ParticipationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['as' => 'api.'], function () {
    // Authentication
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [AuthenticationController::class, 'register'])
            ->name('register.store');
        Route::post('login', [AuthenticationController::class, 'login'])
            ->name('login.store');
    });

    Route::group(['middleware' => 'auth:sanctum'], function () {
        // Check Profile
        Route::get('auth/me', [AuthenticationController::class, 'me'])
           ->name('me');
       // Update Profile
        Route::put('users', [UserController::class, 'update'])
            ->name('users.update');


       // Join event
        Route::post('events/{event}/action/join', [EventController::class, 'join'])
            ->name('events.join');

        // Event Participations
        Route::get('/participations', [ParticipationController::class, 'index'])
            ->name('participations.index');
        Route::patch('/participations/{participation}', [ParticipationController::class, 'present'])
            ->name('participations.present');
        Route::get('/events/{event}/check-joined', [ParticipationController::class, 'checkJoined'])
            ->name('check-joined');
    });

    // Events
    Route::apiResource('events', EventController::class)
        ->only(['index', 'show']);
    Route::get('/events-pagination', [EventController::class, 'indexPagination'])
        ->name('events.pagination');

    // Articles
    Route::apiResource('articles', ArticleController::class)->only(['index', 'show']);
});



