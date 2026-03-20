<?php

namespace App\Http\Controllers;

use App\Models\Edition;

class HomeController extends Controller
{
    public function accueil()
    {
        $edition = Edition::getCurrentEdition();

        return view('accueil', ['edition' => $edition]);
    }

    public function festival()
    {
        $edition = Edition::getCurrentEdition();

        return view('festival', ['edition' => $edition]);
    }

    public function benevoles()
    {
        $edition = Edition::getCurrentEdition();

        return view('benevoles', ['edition' => $edition]);
    }

    public function camping()
    {
        $edition = Edition::getCurrentEdition();

        return view('camping', ['edition' => $edition]);
    }

    public function charte()
    {
        $edition = Edition::getCurrentEdition();

        return view('charte', ['edition' => $edition]);
    }

    public function contact()
    {
        $edition = Edition::getCurrentEdition();

        return view('contact', ['edition' => $edition]);
    }

    public function partenaires()
    {
        $edition = Edition::getCurrentEdition();

        return view('partenaires', ['edition' => $edition]);
    }
}
