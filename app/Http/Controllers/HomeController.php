<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\EditionController;
use App\Http\Controllers\Admin\ArtisteController;

class HomeController extends Controller
{
    public function accueil()
    {
        $edition = app(EditionController::class)->getActiveEdition();
        $artistsByDay = app(ArtisteController::class)->getArtistsGroupedByDay();

        return view('accueil', ['edition' => $edition, 'artistsByDay' => $artistsByDay]);
    }
}
