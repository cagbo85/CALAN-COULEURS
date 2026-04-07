<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function accueil()
    {
        return view('accueil');
    }

    public function festival()
    {
        return view('festival');
    }

    public function benevoles()
    {
        return view('benevoles');
    }

    public function camping()
    {
        return view('camping');
    }

    public function charte()
    {
        return view('charte');
    }

    public function contact()
    {
        return view('contact');
    }

    public function partenaires()
    {
        return view('partenaires');
    }
}
