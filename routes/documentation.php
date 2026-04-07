<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/documentation', function () {
        return view('admin.documentation');
    })->name('admin.documentation');
});
