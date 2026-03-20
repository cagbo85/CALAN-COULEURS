<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgrammationController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [HomeController::class, 'accueil'])->name('accueil');

Route::get('programmation', [ProgrammationController::class, 'index'])->name('programmation');

Route::get('notre-histoire', [HomeController::class, 'festival'])->name('festival');

Route::get('contact', [HomeController::class, 'contact'])->name('contact');

Route::get('benevoles', [HomeController::class, 'benevoles'])->name('benevoles');

Route::get('charte', [HomeController::class, 'charte'])->name('charte');

Route::get('partenaires', [HomeController::class, 'partenaires'])->name('partenaires');

Route::get('camping', [HomeController::class, 'camping'])->name('camping');

require __DIR__.'/auth.php';
require __DIR__.'/artistes.php';
require __DIR__.'/faqs.php';
require __DIR__.'/users.php';
require __DIR__.'/boutique.php';
require __DIR__.'/editions.php';
