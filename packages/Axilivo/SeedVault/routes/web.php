<?php

use Illuminate\Support\Facades\Route;
use Axilivo\SeedVault\Controllers\SnapshotController;

Route::middleware(['web'])->prefix('seedvault')->group(function () {
    Route::get('/', [SnapshotController::class, 'index']);
    Route::post('/create', [SnapshotController::class, 'create']);
    Route::post('/restore', [SnapshotController::class, 'restore']);
    Route::delete('/delete', [SnapshotController::class, 'delete']);
});
