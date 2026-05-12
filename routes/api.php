<?php

use App\Http\Controllers\MobileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [MobileController::class, 'login']);
Route::post('/auth/register', [MobileController::class, 'register']);


Route::prefix('/v2')->middleware(['auth:sanctum', 'throttle:api'])->group(function() {
    Route::post('/logout', [MobileController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});