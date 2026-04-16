<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttractionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserAuthController;

// Public routes
Route::get('/', [AttractionController::class, 'welcome'])->name('home');
Route::get('/attractions', [AttractionController::class, 'index'])->name('attractions.index');
Route::get('/attractions/{id}', [AttractionController::class, 'show'])->name('attractions.show');
Route::get('/map', [AttractionController::class, 'map'])->name('attractions.map');

// User auth routes
Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.post');
Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [UserAuthController::class, 'register'])->name('register.post');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

// Protected trip planning routes
Route::middleware('auth')->group(function () {
    Route::get('/plan-my-trip', [UserAuthController::class, 'planTrip'])->name('trip.plan');
    Route::post('/plan-my-trip', [UserAuthController::class, 'saveTrip'])->name('trip.save');
    Route::delete('/plan-my-trip/{id}', [UserAuthController::class, 'deleteTrip'])->name('trip.delete');
});

// Admin routes
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