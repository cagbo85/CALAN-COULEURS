<?php

namespace App\Providers;

use App\Models\Edition;
use App\Services\HelloAssoService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(HelloAssoService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Partager l'édition actuelle avec les vues d'erreur
        View::composer('errors::*', function ($view) {
            $view->with('currentEdition', Edition::getCurrentEdition());
        });

        View::composer('*', function ($view) {
            $currentEdition = Edition::getCurrentEdition();

            // Définir quels liens afficher selon le statut
            $showProgrammation = $currentEdition && in_array($currentEdition->status, ['upcoming', 'ongoing', 'past']);
            $showPartenaires = $currentEdition && in_array($currentEdition->status, ['upcoming', 'ongoing', 'past']);
            // $showPhotoSouvenirs = $currentEdition && in_array($currentEdition->status, ['past']);
            // $showNews = $currentEdition && in_array($currentEdition->status, ['upcoming','past']);

            $view->with([
                'currentEdition' => $currentEdition,
                'showProgrammation' => $showProgrammation,
                'showPartenaires' => $showPartenaires,
                // 'showPhotoSouvenirs' => $showPhotoSouvenirs,
                // 'showNews' => $showNews,
            ]);
        });
    }
}
