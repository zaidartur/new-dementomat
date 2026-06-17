<?php

use App\Http\Controllers\MobileController;
use App\Http\Controllers\MobileSkriningController;
use App\Http\Controllers\MobileUserController;
use App\Http\Controllers\MobileUtilityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [MobileController::class, 'login']);
Route::post('/auth/register', [MobileController::class, 'register']);


Route::prefix('/v2')->middleware(['auth:sanctum', 'throttle:api'])->group(function() {
    Route::post('/logout', [MobileController::class, 'logout']);
    Route::post('/deactivate', [MobileController::class, 'deactivate']);

    Route::prefix('/pendukung')->group(function() {
        Route::get('/data-faskes', [MobileUtilityController::class, 'data_faskes']);
        Route::get('/data-kecamatan', [MobileUtilityController::class, 'data_kecamatan']);
        Route::get('/data-desa', [MobileUtilityController::class, 'data_desa']);
        Route::get('/data-desa-kecamatan/{kec}', [MobileUtilityController::class, 'data_desa_by_kecamatan']);
        Route::get('/data-kontak', [MobileUtilityController::class, 'data_kontak']);
        Route::get('/data-video', [MobileUtilityController::class, 'data_youtube']);
        Route::get('/data-slider', [MobileUtilityController::class, 'data_slider']);
        Route::get('/data-berita', [MobileUtilityController::class, 'data_berita']);
    });

    Route::prefix('/skrining')->group(function() {
        Route::post('/baru', [MobileSkriningController::class, 'show_parameter']);
        Route::post('/simpan', [MobileSkriningController::class, 'save_parameter'])->middleware('throttle:api');
        Route::post('/riwayat', [MobileSkriningController::class, 'riwayat_skrining']);
        Route::post('/detail-skrining', [MobileSkriningController::class, 'detail_skrining']);

        Route::post('/tes-dahak', [MobileSkriningController::class, 'submit_dahak']);
        Route::get('/file-hasil-tes-dahak/{uid}', [MobileSkriningController::class, 'file_dahak'])->name('tcm.file');
        Route::post('/daftar-efek-samping', [MobileSkriningController::class, 'list_efek'])->middleware('throttle:api');
        Route::post('/pemantauan-obat', [MobileSkriningController::class, 'submit_log_obat'])->middleware('throttle:api');
        Route::post('/riwayat-pemantauan-obat', [MobileSkriningController::class, 'logs_pemantauan_obat']);
        Route::post('/berat-badan-bulanan', [MobileSkriningController::class, 'submit_berat_badan'])->middleware('throttle:api');
        Route::post('/riwayat-berat-badan', [MobileSkriningController::class, 'logs_berat_badan']);
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