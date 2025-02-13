<?php

use App\Http\Controllers\Api\User\ProductProcessImageController;
use App\Http\Controllers\Api\User\ProductReportableController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->middleware(['auth:sanctum'])->group(function () {
    Route::post('products/{product}/reportables', [ProductReportableController::class, 'store'])
        ->name('products.reportables.store');

    Route::post('/products/process-image', [ProductProcessImageController::class, 'processImage'])
        ->name('products.process-image');
});
