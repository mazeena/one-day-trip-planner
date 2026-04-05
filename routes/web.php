<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttractionController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [AttractionController::class, 'index'])->name('home');
Route::get('/attractions', [AttractionController::class, 'index'])->name('attractions.index');
Route::get('/attractions/{id}', [AttractionController::class, 'show'])->name('attractions.show');
Route::get('/map', [AttractionController::class, 'map'])->name('attractions.map');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes (no middleware)
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');

    // Protected admin routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

        // Attraction CRUD
        Route::get('/attractions', [AdminController::class, 'attractionIndex'])->name('attractions.index');
        Route::get('/attractions/create', [AdminController::class, 'attractionCreate'])->name('attractions.create');
        Route::post('/attractions', [AdminController::class, 'attractionStore'])->name('attractions.store');
        Route::get('/attractions/{id}/edit', [AdminController::class, 'attractionEdit'])->name('attractions.edit');
        Route::put('/attractions/{id}', [AdminController::class, 'attractionUpdate'])->name('attractions.update');
        Route::delete('/attractions/{id}', [AdminController::class, 'attractionDestroy'])->name('attractions.destroy');
    });
});
