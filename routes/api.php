<?php

use App\Http\Controllers\MobileController;
use App\Http\Controllers\MobileSkriningController;
use App\Http\Controllers\MobileUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [MobileController::class, 'login']);
Route::post('/auth/register', [MobileController::class, 'register']);


Route::prefix('/v2')->middleware(['auth:sanctum', 'throttle:api'])->group(function() {
    Route::post('/logout', [MobileController::class, 'logout']);

    Route::prefix('/skrining')->group(function() {
        Route::post('/baru', [MobileSkriningController::class, 'show_parameter']);
        Route::post('/simpan', [MobileSkriningController::class, 'save_parameter'])->middleware('throttle:api');
    });

    Route::prefix('/user')->group(function() {
        Route::get('/profile', [MobileUserController::class, 'profile']);
        Route::patch('/username', [MobileUserController::class, 'update_username']);
        Route::patch('/password', [MobileController::class, 'ubah_password']);
        Route::put('/profile', [MobileUserController::class, 'update_biodata']);

        Route::get('/keluarga', [MobileUserController::class, 'keluarga']);
        Route::post('/keluarga', [MobileUserController::class, 'tambah_keluarga']);
        Route::put('/keluarga', [MobileUserController::class, 'update_keluarga']);
        Route::delete('/keluarga', [MobileUserController::class, 'hapus_keluarga']);
    });
});