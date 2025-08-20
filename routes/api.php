<?php

use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;

Route::get('/faqs', [FaqController::class, 'getAllFaqs'])
    ->name('faqs.index');
