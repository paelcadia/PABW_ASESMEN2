<?php

use Illuminate\Support\Facades\Route;
use Modules\Donasis\Http\Controllers\DonasisController;

Route::middleware(['auth'])->group(function () {
    Route::get('Donasis', [DonasisController::class, 'index'])->name('Donasis.index');
    Route::middleware('role:admin')->group(function () {
        Route::get('Donasis/create', [DonasisController::class, 'create'])->name('Donasis.create');
        Route::post('Donasis', [DonasisController::class, 'store'])->name('Donasis.store');
        Route::get('Donasis/{Donasi}/edit', [DonasisController::class, 'edit'])->name('Donasis.edit');
        Route::put('Donasis/{Donasi}', [DonasisController::class, 'update'])->name('Donasis.update');
        Route::delete('Donasis/{Donasi}', [DonasisController::class, 'destroy'])->name('Donasis.destroy');
    });
});
