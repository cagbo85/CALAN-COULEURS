<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('accueil');
});

Route::get('programmation', function () {
    return view('lineup');
})->name('programmation');

Route::get('notre-histoire', function () {
    return view('festival');
})->name('festival');

Route::get('contact', function () {
    return view('contact');
})->name('contact');
