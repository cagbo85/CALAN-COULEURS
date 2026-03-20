<?php

use App\Http\Controllers\Admin\ArtisteController;
use App\Http\Controllers\Admin\EditionController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\StandController;
use Illuminate\Support\Facades\Route;

Route::get('/faqs', [FaqController::class, 'getAllFaqs'])
    ->name('faqs.index');

Route::get('/partenaires', [PartenaireController::class, 'getAllPartenaires'])
    ->name('partenaires.index');

Route::get('/partenaires/current', [PartenaireController::class, 'getPartenairesCurrentEdition'])
    ->name('partenaires.current');

Route::get('/edition/current', [EditionController::class, 'getCurrentEdition'])
    ->name('editions.current');

Route::get('/artists/current', [ArtisteController::class, 'getArtistsGroupedByDayCurrentEdition'])
    ->name('artists.current');

Route::get('stands/current', [StandController::class, 'getStandsCurrentEdition'])
    ->name('stands.current');
