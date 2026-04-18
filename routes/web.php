<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttractionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TripController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/attractions', [AttractionController::class, 'index'])->name('attractions.index');
Route::get('/attractions/{id}', [AttractionController::class, 'show'])->name('attractions.show');
Route::get('/map', [AttractionController::class, 'map'])->name('attractions.map');

/*
|--------------------------------------------------------------------------
| Trip Routes
|--------------------------------------------------------------------------
*/

Route::get('/trip/plan', [TripController::class, 'index'])->name('trip.plan');
Route::post('/trip/save', [TripController::class, 'save'])->name('trip.save');
Route::delete('/trip/{id}', [TripController::class, 'destroy'])->name('trip.delete');

/*
|--------------------------------------------------------------------------
| Review Routes
|--------------------------------------------------------------------------
*/

Route::middleware('admin.auth')->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

        Route::get('/attractions', [AdminController::class, 'attractionIndex'])->name('attractions.index');
        Route::get('/attractions/create', [AdminController::class, 'attractionCreate'])->name('attractions.create');
        Route::post('/attractions', [AdminController::class, 'attractionStore'])->name('attractions.store');
        Route::get('/attractions/{id}/edit', [AdminController::class, 'attractionEdit'])->name('attractions.edit');
        Route::put('/attractions/{id}', [AdminController::class, 'attractionUpdate'])->name('attractions.update');
        Route::delete('/attractions/{id}', [AdminController::class, 'attractionDestroy'])->name('attractions.destroy');
    });
});