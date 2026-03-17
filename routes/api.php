<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthDataController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SelectController;
use App\Http\Controllers\SendContactController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TestimonialController;
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

    Route::apiResource('roles', RoleController::class);
    Route::get('select/roles', [SelectController::class, 'roles']);

    Route::apiResource('users', UserController::class);

    Route::apiResource('settings', SettingController::class)->only('index', 'show', 'store');

    Route::apiResource('clients', ClientController::class);
    Route::get('select/clients', [SelectController::class, 'clients']);

    Route::apiResource('projects', ProjectController::class);

    Route::apiResource('products', ProductController::class);

    // admin contact us
    Route::apiResource('contact-us', ContactUsController::class);

    Route::apiResource('categories', controller: CategoryController::class);
    Route::get('select/categories', [SelectController::class, 'categories']);

    Route::apiResource('blogs', BlogController::class);

    Route::apiResource('testimonials', TestimonialController::class);

});

// Public routes
Route::prefix('/public')->group(function () {

    Route::apiResource('settings', SettingController::class)->only('index', 'show');
    Route::apiResource('clients', ClientController::class)->only('index', 'show');
    Route::apiResource('projects', ProjectController::class)->only('index', 'show');
    Route::apiResource('products', ProductController::class)->only('index', 'show');
    Route::apiResource('categories', CategoryController::class)->only('index', 'show');
    Route::apiResource('blogs', BlogController::class)->only('index', 'show');
    Route::apiResource('testimonials', TestimonialController::class)->only('index', 'show');

    // Contact Us

    Route::post('send-contact', SendContactController::class)
        ->middleware('throttle:2,1');

});
