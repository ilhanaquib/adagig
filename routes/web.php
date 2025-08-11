<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// Authentication routes
Route::get('/signup', function () {
    return Inertia::render('Auth/Signup');
})->middleware(['guest'])->name('signup');
Route::post('/signup', [RegisteredUserController::class, 'store'])
    ->middleware(['guest'])
    ->name('register');
Route::get('/register', function () {
    abort(404);
});
