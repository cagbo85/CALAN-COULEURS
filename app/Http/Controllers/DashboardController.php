<?php

namespace App\Http\Controllers;

use App\Models\Artiste;
use App\Models\Faq;
use App\Models\User;
use App\Models\Edition;

class DashboardController extends Controller
{
    /**
     * Afficher le dashboard avec les statistiques
     */
    public function index()
    {
        // Récupérer l'édition actuelle
        $currentEdition = Edition::getCurrentEdition();

        $stats = [
            'artistes' => [
                'global' => [
                    'total' => Artiste::count(),
                ],
                'edition_courante' => $currentEdition ? [
                    'total' => $currentEdition->performances()->count(),
                    'actifs' => $currentEdition->performances()->where('actif', true)->count(),
                    'masques' => $currentEdition->performances()->where('actif', false)->count(),
                ] : null,
            ],
            'users' => [
                'total' => User::count(),
                'verified' => User::whereNotNull('email_verified_at')->count(),
                'unverified' => User::whereNull('email_verified_at')->count(),
                'actifs' => User::where('actif', 1)->count(),
                'desactives' => User::where('actif', 0)->count(),
            ],
            'faqs' => [
                'total' => Faq::count(),
                'actives' => Faq::where('actif', true)->count(),
                'masquees' => Faq::where('actif', false)->count(),
            ],
            'editions' => [
                'total' => Edition::count(),
                'draft' => Edition::where('status', 'draft')->count(),
                'actives' => Edition::whereIn('status', ['upcoming', 'ongoing'])->count(),
                'inactives' => Edition::whereIn('status', ['past', 'archived'])->count(),
            ],
        ];

        return view('dashboard', compact('stats'));
    }
}
