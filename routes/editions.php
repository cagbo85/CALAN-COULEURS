<?php

use App\Http\Controllers\Admin\ArtisteController;
use App\Http\Controllers\Admin\EditionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/editions', [EditionController::class, 'index'])->name('admin.editions.index');
    Route::get('/editions/create', [EditionController::class, 'create'])->name('admin.editions.create');
    Route::post('/editions/create', [EditionController::class, 'store'])->name('admin.editions.store');
    Route::put('/editions/{editionId}', [EditionController::class, 'update'])->name('admin.editions.update');
    Route::get('/editions/{editionId}', [EditionController::class, 'show'])->name('admin.editions.show');

    Route::get('/editions/{editionId}/performances', [ArtisteController::class, 'getPerformancesByEdition'])->name('admin.editions.performances.index');
    Route::get('/editions/{editionId}/performances/create', [ArtisteController::class, 'createPerformance'])->name('admin.editions.performances.create');
    Route::post('/editions/{editionId}/performances/create', [ArtisteController::class, 'storePerformance'])->name('admin.editions.performances.store');
    Route::post('/editions/{editionId}/performances/{artisteId}', [ArtisteController::class, 'attachPerformToEdition'])->name('admin.editions.performances.attach');
    Route::post('/editions/{editionId}/performances/{artisteId}/hide', [ArtisteController::class, 'hidePerformFromEdition'])->name('admin.editions.performances.hide');
    Route::post('/editions/{editionId}/performances/{artisteId}/show', [ArtisteController::class, 'showPerformFromEdition'])->name('admin.editions.performances.show');
    Route::delete('/editions/{editionId}/performances/{artisteId}', [ArtisteController::class, 'deletePerformFromEdition'])->name('admin.editions.performances.delete');
});
