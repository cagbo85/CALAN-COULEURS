<?php

use App\Http\Controllers\DashboardController;
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

Route::get('/', function () {
    return view('accueil');
})->name('accueil');

Route::get('programmation', [ProgrammationController::class, 'index'])->name('programmation');

Route::get('notre-histoire', function () {
    return view('festival');
})->name('festival');

Route::get('contact', function () {
    return view('contact');
})->name('contact');

Route::get('benevoles', function () {
    return view('benevoles');
})->name('benevoles');

Route::get('charte', function () {
    return view('charte');
})->name('charte');

Route::get('/partenaires', function () {
    return view('partenaires');
})->name('partenaires');

Route::get('camping', function () {
    return view('camping');
})->name('camping');

require __DIR__.'/auth.php';
require __DIR__.'/artistes.php';
require __DIR__.'/faqs.php';
require __DIR__.'/users.php';
require __DIR__.'/boutique.php';
