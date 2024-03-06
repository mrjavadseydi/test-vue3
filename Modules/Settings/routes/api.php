<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware(['auth:sanctum','role:admin'])->prefix('v1')->name('api.')->group(function () {
    Route::get('/settings', [\Modules\Settings\App\Http\Controllers\SettingsController::class,'index'])->name('settings.index');
    Route::post('/settings', [\Modules\Settings\App\Http\Controllers\SettingsController::class,'store'])->name('settings.store');
});
