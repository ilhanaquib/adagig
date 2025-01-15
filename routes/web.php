<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReleaseController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/', function () {
//     return Inertia::render('Home');
// })->name('home');


// Home page
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// Events page
Route::get('events', [EventController::class, 'index'])->name('events.index');

// Releases page
Route::get('events', [ReleaseController::class, 'index'])->name('release.index');


// Route::get('/event/{id}', [HomeController::class, 'show'])->name('event.show');
// Route::get('/add-event', [HomeController::class, 'addEvent'])->name('event.addEvent');
// Route::post('/submit-event', [HomeController::class, 'submitEvent'])->name('event.submit');
// Route::get('/map', [HomeController::class, 'map'])->name('event.map');

// Middleware
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
