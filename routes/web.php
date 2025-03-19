<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('accueil');
});

/* Route::get('/navbar', function () {
    return view('partials.navbar');
}); */
