<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthDataController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SendContactController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });

    Route::get('auth-data', [AuthDataController::class]);

    Route::get('auth-data', AuthDataController::class);

    Route::apiResource('roles', RoleController::class);

    Route::apiResource('users', UserController::class);

    Route::apiResource('settings', SettingsController::class)->only('index', 'update');

    Route::apiResource('clients', ClientController::class);

    Route::apiResource('projects', ProjectsController::class);

    Route::apiResource('products', ProductController::class);

    // admin contact us
    Route::apiResource('contact-us', ContactUsController::class);

    Route::apiResource('categories', controller: CategoryController::class);

    Route::apiResource('blogs', BlogController::class);

});

// Contact Us

// public

Route::post('send-contact', SendContactController::class)
    ->middleware('throttle:2,1');


