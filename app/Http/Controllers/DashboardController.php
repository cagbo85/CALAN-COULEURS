<?php

// filepath: app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Artiste;
use App\Models\Faq;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Afficher le dashboard avec les statistiques
     */
    public function index()
    {
        $stats = [
            'artistes' => [
                'total' => Artiste::count(),
                'actifs' => Artiste::where('actif', true)->count(),
                'masques' => Artiste::where('actif', false)->count(),
            ],
            'users' => [
                'total' => User::count(),
                'verified' => User::whereNotNull('email_verified_at')->count(),
                'unverified' => User::whereNull('email_verified_at')->count(),
            ],
            'faqs' => [
                'total' => Faq::count(),
                'actives' => Faq::where('actif', true)->count(),
                'masquees' => Faq::where('actif', false)->count(),
            ],
        ];

        return view('dashboard', compact('stats'));
    }
}
