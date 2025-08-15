<?php

use App\Http\Controllers\Admin\ArtisteController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {
    Route::get('artistes', [ArtisteController::class, 'getAllArtistes'])->name('admin.artistes.index');
    Route::get('artistes/create', [ArtisteController::class, 'create'])->name('admin.artistes.create');
    Route::post('artistes/create', [ArtisteController::class, 'store'])->name('admin.artistes.store');
    Route::get('artistes/{artisteId}', [ArtisteController::class, 'show'])->name('admin.artistes.show');
    Route::put('artistes/{artisteId}', [ArtisteController::class, 'update'])->name('admin.artistes.update');
    Route::delete('artistes/{artisteId}', [ArtisteController::class, 'destroy'])->name('admin.artistes.destroy');
});
