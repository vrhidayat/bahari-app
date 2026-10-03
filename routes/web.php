<?php

use App\Http\Controllers\SaleController;
use App\Http\Controllers\WasteScanController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::post('scan/predict', WasteScanController::class)->name('waste-scan.predict');
    Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
});

require __DIR__.'/settings.php';
