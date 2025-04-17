<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\OltController;
use Illuminate\Support\Facades\Route;

// Redirect root to login or dashboard
Route::redirect('/', '/login');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // MikroTik Devices
    Route::resource('devices', DeviceController::class)->only(['index', 'create', 'store']);

    // OLT Devices
    Route::resource('olts', OltController::class)->only(['index', 'create', 'store']);
});
