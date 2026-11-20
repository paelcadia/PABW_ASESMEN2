<?php

use Illuminate\Support\Facades\Route;
use Modules\Pengajuan\Http\Controllers\PengajuanController;

Route::middleware(['auth'])->group(function () {
    Route::get('Pengajuans', [PengajuanController::class, 'index'])->name('Pengajuan.index');
    Route::post('Pengajuans', [PengajuanController::class, 'store'])->name('Pengajuan.store');
    Route::get('Pengajuans/{Pengajuan}', [PengajuanController::class, 'show'])->name('Pengajuan.show');
    Route::get('Pengajuans/{Pengajuan}/edit', [PengajuanController::class, 'edit'])->name('Pengajuan.edit');
    Route::put('Pengajuans/{Pengajuan}', [PengajuanController::class, 'update'])->name('Pengajuan.update');
    Route::delete('Pengajuans/{Pengajuan}', [PengajuanController::class, 'destroy'])->name('Pengajuan.destroy');
    Route::patch('Pengajuans/{Pengajuan}/status', [PengajuanController::class, 'updateStatus'])
        ->name('Pengajuan.status');
});
