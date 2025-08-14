<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubmissionController;
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
    Route::get('/add', function () {
        return Inertia::render('Add');
    })->name('add');
    Route::post('/submit-new-item', [SubmissionController::class, 'store'])->name('submit.new');
});

// Navigation routes
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// Event routes
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit'); //middleware for edit
Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update'); //middleware for update
Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy'); //middleware for delete
