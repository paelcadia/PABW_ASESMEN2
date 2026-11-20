<?php

use Illuminate\Support\Facades\Route;
use Modules\Donasis\Http\Controllers\DonasisController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('Donasis', DonasisController::class)->names('Donasis');
});
