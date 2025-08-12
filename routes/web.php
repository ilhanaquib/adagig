<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
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

Route::get('/signin', function () {
    return Inertia::render('Auth/Signin');
})->middleware(['guest'])->name('login');

Route::post('/signin', [LoginController::class, 'store'])
    ->middleware(['guest'])
    ->name('login');


Route::post('/signout', [LoginController::class, 'destroys'])
    ->middleware(['auth'])
    ->name('logout');

Route::get('/login', function () {
    abort(404);
});

// Authenticated routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/profile', function () {
        return Inertia::render('Profile');
    })->name('profile');
});

// Navigation routes
// Navigation routes
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');
