<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});


Route::prefix('/')->middleware('auth')->group(function() {
    Route::get('dashboard', [DashboardController::class, 'view'])->name('dashboard');

    Route::prefix('user/')->group(function() {
        Route::middleware(['permission:view pengguna', 'permission:view keluarga'])->group(function() {
            Route::get('pengguna', [UserController::class, 'pengguna'])->name('pengguna');
            Route::get('detail-pengguna/{uid}', [UserController::class, 'detail_pengguna'])->name('pengguna.detail');
            Route::get('tabel-pengguna', [UserController::class, 'ss_pengguna'])->name('pengguna.ss');
        });
        Route::post('update-pengguna', [UserController::class, 'update_pengguna'])->name('pengguna.update')->middleware('permission:update pengguna');
        Route::post('update-username', [UserController::class, 'update_username_pengguna'])->name('pengguna.username')->middleware('permission:update username pengguna');
        Route::post('update-password', [UserController::class, 'update_password_pengguna'])->name('pengguna.password')->middleware('permission:update password pengguna');
        Route::post('hapus-pengguna', [UserController::class, 'hapus_pengguna'])->name('pengguna.hapus')->middleware('permission:hapus pengguna');

        Route::post('simpan-keluarga', [UserController::class, 'simpan_keluarga'])->name('pengguna.keluarga.simpan')->middleware('permission:simpan keluarga');
        Route::post('update-keluarga', [UserController::class, 'update_keluarga'])->name('pengguna.keluarga.update')->middleware('permission:update keluarga');
        Route::post('hapus-keluarga', [UserController::class, 'hapus_keluarga'])->name('pengguna.keluarga.hapus')->middleware('permission:hapus keluarga');
    });
});

require __DIR__.'/auth.php';