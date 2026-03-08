<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthDataController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
    Route::get('auth-data', [AuthDataController::class, '__invoke']);




    Route::apiResource('users', UserController::class);
    Route::apiResource('settings', SettingsController::class);


});
