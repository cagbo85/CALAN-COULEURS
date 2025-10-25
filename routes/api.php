<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\EditionController;
use App\Http\Controllers\PartenaireController;

Route::get('/faqs', [FaqController::class, 'getAllFaqs'])
    ->name('faqs.index');

Route::get('/stands', [StandController::class, 'getAllStands'])
    ->name('stands.index');

Route::get('/partenaires', [PartenaireController::class, 'getAllPartenaires'])
    ->name('partenaires.index');

Route::get('/active/editions', [EditionController::class, 'getAllActiveEditions'])
    ->name('editions.active.index');
