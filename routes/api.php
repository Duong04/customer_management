<?php

use App\Http\Controllers\Apis\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function() {
    Route::controller(UserController::class)->prefix('users')->group(function() {
        Route::put('/{id}', 'update');
    });
});