<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BandController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\UserController;
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
    // User
    Route::get('/profile', [ProfileController::class, 'me'])->name('profile.me');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/users/{user}/follow', [FollowController::class, 'store'])
        ->name('users.follow');
    Route::delete('/users/{user}/unfollow', [FollowController::class, 'destroy'])
        ->name('users.unfollow');


    // submission 
    Route::get('/add', function () {
        return Inertia::render('Add');
    })->name('add');
    Route::post('/submit-new-item', [SubmissionController::class, 'store'])->name('submit.new');

    // Event
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

    // Groups
    Route::get('/group/create', [GroupController::class, 'create'])->name('group.create');
    Route::post('/group/store', [GroupController::class, 'store'])->name('group.store');
    Route::post('/bands', [BandController::class, 'store'])->name('bands.store');
    Route::get('/bands/me', [BandController::class, 'me'])->name('bands.me');
    Route::get('/organisations/me', [OrganisationController::class, 'me'])->name('organisations.me');
});

// Navigation routes
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// Users routes
Route::get('/users/search', [UserController::class, 'search'])->name('api.users.search');


// Event routes
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// Profile routes
Route::get('/profile/{user:username}', [ProfileController::class, 'show'])->name('profile.show');

// Band routes
Route::get('/bands', [BandController::class, 'index'])->name('bands.index');
Route::get('/bands/{band:name}', [BandController::class, 'show'])->name('bands.show');

// Organisation routes
Route::get('/organisations', [OrganisationController::class, 'index'])->name('organisations.index');
Route::get('/organisations/{organisation:name}', [OrganisationController::class, 'show'])->name('organisations.show');
