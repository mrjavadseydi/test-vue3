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

Route::middleware(['auth:sanctum','role:admin,operator'])->prefix('v1')->name('api.')->group(function () {
   Route::resource('users', \Modules\Users\App\Http\Controllers\UsersController::class)->names('users');
});
