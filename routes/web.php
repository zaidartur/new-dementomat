<?php

use App\Http\Controllers\CekDahakController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\MobileUtilityController;
use App\Http\Controllers\PantauanObatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkriningController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
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

        Route::post('edit-pengguna', [UserController::class, 'edit_pengguna'])->name('pengguna.edit')->middleware('permission:update pengguna');
        Route::post('update-pengguna', [UserController::class, 'update_pengguna'])->name('pengguna.update')->middleware('permission:update pengguna');
        Route::post('update-username', [UserController::class, 'update_username_pengguna'])->name('pengguna.username')->middleware('permission:update username pengguna');
        Route::post('update-password', [UserController::class, 'update_password_pengguna'])->name('pengguna.password')->middleware('permission:update password pengguna');
        Route::post('hapus-pengguna', [UserController::class, 'hapus_pengguna'])->name('pengguna.hapus')->middleware('permission:hapus pengguna');
        Route::post('reaktivasi-pengguna', [UserController::class, 'reactivate_pengguna'])->name('pengguna.reaktivasi')->middleware('permission:reaktivasi pengguna');

        Route::post('simpan-keluarga', [UserController::class, 'simpan_keluarga'])->name('pengguna.keluarga.simpan')->middleware('permission:simpan keluarga');
        Route::post('edit-keluarga', [UserController::class, 'edit_keluarga'])->name('pengguna.keluarga.edit')->middleware('permission:update keluarga');
        Route::post('update-keluarga', [UserController::class, 'update_keluarga'])->name('pengguna.keluarga.update')->middleware('permission:update keluarga');
        Route::post('hapus-keluarga', [UserController::class, 'hapus_keluarga'])->name('pengguna.keluarga.hapus')->middleware('permission:hapus keluarga');
    });

    Route::prefix('skrining/')->group(function() {
        Route::get('view', [SkriningController::class, 'view'])->name('skrining')->middleware('permission:view hasil skrining');
        Route::get('data-skrining', [SkriningController::class, 'ss_skrining'])->name('skrining.ss')->middleware('permission:view hasil skrining');
        Route::post('detail', [SkriningController::class, 'detail'])->name('skrining.detail')->middleware('permission:view hasil skrining');
        Route::post('revisi-hasil-skrining', [SkriningController::class, 'revisi_skrining'])->name('skrining.revisi')->middleware('permission:update hasil skrining');
    });

    Route::prefix('penanganan/')->group(function() {
        Route::get('cek-dahak', [CekDahakController::class, 'view'])->name('dahak')->middleware('permission:view cek dahak');
        Route::get('tabel-dahak', [CekDahakController::class, 'ss_dahak'])->name('dahak.ss')->middleware('permission:view cek dahak');
        Route::post('submit-manual', [CekDahakController::class, 'simpan_cek_manual'])->name('dahak.faskes')->middleware('permission:input cek manual');
        Route::post('verifikasi', [CekDahakController::class, 'verifikasi_hasil'])->name('dahak.verify')->middleware('permission:verifikasi dahak');

        Route::get('pemantauan-obat', [PantauanObatController::class, 'view'])->name('obat')->middleware('permission:view pemantauan obat');
        Route::get('tabel-pemantauan', [PantauanObatController::class, 'ss_obat'])->name('obat.ss')->middleware('permission:view pemantauan obat');
        Route::post('detail-pengguna', [PantauanObatController::class, 'detail_user'])->name('obat.detail')->middleware('permission:view pemantauan obat');
        Route::post('update-status-pengguna', [PantauanObatController::class, 'simpan_hasil_akhir'])->name('obat.status')->middleware('permission:ubah status obat');
    });

    Route::prefix('kontak/')->group(function() {
        Route::get('view', [KontakController::class, 'view'])->name('kontak')->middleware('permission:view kontak');
        Route::get('detail/{id}', [KontakController::class, 'detail'])->name('kontak.detail')->middleware('permission:view kontak');
        Route::post('simpan', [KontakController::class, 'simpan'])->name('kontak.simpan')->middleware('permission:simpan kontak');
        Route::post('update', [KontakController::class, 'update'])->name('kontak.update')->middleware('permission:update kontak');
        Route::post('hapus', [KontakController::class, 'hapus'])->name('kontak.hapus')->middleware('permission:hapus kontak');
    });

    Route::prefix('pengaturan/')->group(function() {
        Route::get('slider', [UtilityController::class, 'view_slider'])->name('slider')->middleware('permission:view slider');
        Route::get('video', [UtilityController::class, 'view_youtube'])->name('video')->middleware('permission:view video');
    });

    Route::prefix('utility/')->group(function() {
        Route::get('/data-faskes', [MobileUtilityController::class, 'data_faskes']);
        Route::get('/data-kecamatan', [MobileUtilityController::class, 'data_kecamatan']);
        Route::get('/data-desa', [MobileUtilityController::class, 'data_desa']);
        Route::get('/data-desa-kecamatan/{kec}', [MobileUtilityController::class, 'data_desa_by_kecamatan']);
        Route::get('/data-kontak', [MobileUtilityController::class, 'data_kontak']);
        Route::get('/data-video', [MobileUtilityController::class, 'data_youtube']);
        Route::get('/data-slider', [MobileUtilityController::class, 'data_slider']);
        Route::get('/data-berita', [MobileUtilityController::class, 'data_berita']);
    });
});

require __DIR__.'/auth.php';