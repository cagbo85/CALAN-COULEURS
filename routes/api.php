<?php

use App\Http\Controllers\FaqController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\PartenaireController;
use Illuminate\Support\Facades\Route;

Route::get('/faqs', [FaqController::class, 'getAllFaqs'])
    ->name('faqs.index');

Route::get('/stands', [StandController::class, 'getAllStands'])
    ->name('stands.index');

Route::get('/partenaires', [PartenaireController::class, 'getAllPartenaires'])
    ->name('partenaires.index');
