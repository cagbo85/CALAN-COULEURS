<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{userId}/disable', [UserController::class, 'disable'])->name('admin.users.disable');

    Route::post('/users/{userId}/request-reactivation', [UserController::class, 'requestReactivation'])->name('admin.users.request-reactivation');
    Route::post('/users/{userId}/reactivate', [UserController::class, 'reactivate'])->name('admin.users.reactivate');
    Route::post('/users/{userId}/approve-reactivation', [UserController::class, 'approveReactivation'])->name('admin.users.approve-reactivation');
});
