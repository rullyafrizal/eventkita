<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth
Route::group(['middleware' => 'guest'], function() {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');
});
Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');


Route::group(['middleware' => 'auth'], function() {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Users
    Route::resource('users', UserController::class);
    Route::put('users/{user}/restore', [UserController::class, 'restore'])
        ->name('users.restore');

    // Roles
    Route::resource('roles', RoleController::class);

    // Event Types
    Route::resource('event-types', EventTypeController::class);
    Route::put('event-types/{event_type}/restore', [EventTypeController::class, 'restore'])
        ->name('event-types.restore');

    // Articles
    Route::resource('articles', ArticleController::class);
    Route::put('articles/{article}/restore', [ArticleController::class, 'restore'])
        ->name('articles.restore');
    Route::put('articles/{article}/action/publish', [ArticleController::class, 'publish'])
        ->name('articles.publish');
    Route::post('articles/action/upload', [ArticleController::class, 'upload'])
        ->name('articles.upload');

    // Images
    Route::get('img/{path}', [ImageController::class, 'show'])
        ->where('path', '.*')
        ->name('image');
});
