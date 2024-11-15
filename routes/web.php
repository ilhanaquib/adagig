<?php

use App\Http\Controllers\EventController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [EventController::class, 'index'])->name('home');
Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');

Route::get('/addEvent', [EventController::class, 'addEvent'])->name('event.addEvent');
Route::post('/submitEvent', [EventController::class, 'submitEvent'])->name('event.submitEvent');

// Route::get('/home', function () {
// })->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
