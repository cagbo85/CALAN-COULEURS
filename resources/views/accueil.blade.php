@extends('layouts.app')

@section('title', 'Calan\'Couleurs Festival 2026 à Campbon | Musique, Artistes & Billetterie')

@section('meta')
    <meta name="google-site-verification" content="3j2RcHRKc1fefLWwLlGVFZWlAqh6XvK741ZMDtz1LKA" />
    <meta name="description"
        content="Calan'Couleurs Festival - 26 & 27 juin 2026 à Campbon. Découvrez la programmation, achetez vos billets et rejoignez-nous pour un week-end inoubliable de musique et de convivialité." />
    <meta name="keywords" content="Calan'Couleurs, Calan Couleurs, Festival, musique, Campbon, programmation, billets" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Calan'Couleurs Team" />
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />

    <meta property="og:title" content="CALAN-COULEURS | Festival musical à Campbon" />
    <meta property="og:description"
        content="Festival les 26 & 27 juin 2026 à Campbon. Programmation, billets, infos pratiques." />
    <meta property="og:image" content="https://calan-couleurs.fr/img/logos/accueil_public.png" />
    <meta property="og:url" content="https://calan-couleurs.fr/" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="CALAN-COULEURS | Festival musical à Campbon" />
    <meta name="twitter:description"
        content="Un week-end de musique et de festivités à Campbon les 26 & 27 juin 2026." />
    <meta name="twitter:image" content="https://calan-couleurs.fr/img/logos/accueil_public.png" />
@endsection

@push('scripts')
    @vite(['resources/js/timer-loader.jsx', 'resources/js/onsite-loader.jsx', 'resources/js/faq-loader.jsx'])
@endpush

@section('content')
    <section
        class="min-h-[500px] sm:h-[calc(100vh-64px)] w-full px-2 sm:px-4 py-8 flex flex-col justify-center items-center bg-[url('/img/logos/accueil_public.png')] bg-no-repeat bg-center bg-cover text-center">

        <!-- Dates du festival -->
        <div class="mb-3 sm:mb-4 backdrop-blur-md shadow-lg px-4 sm:px-8 py-2 sm:py-3 rounded-xl border border-white/50"
            style="background: linear-gradient(180deg, rgba(255,15,99,0.2), rgba(143,30,152,0.2), rgba(39,42,199,0.2));">
            <h2 class="text-white text-lg sm:text-xl md:text-2xl font-bold tracking-wider drop-shadow-md">
                VENDREDI 26 & SAMEDI 27 JUIN 2026
            </h2>
        </div>

        <div class="w-full max-w-xl sm:max-w-2xl mx-auto mb-6 sm:mb-10">
            <div class="backdrop-blur-md shadow-lg px-6 sm:px-10 py-8 sm:py-10 rounded-2xl border border-white/50 flex flex-col items-center justify-center text-white text-center"
                style="background: linear-gradient(180deg, rgba(255,15,99,0.3), rgba(143,30,152,0.3), rgba(39,42,199,0.3));">

                <h3 class="text-lg sm:text-xl font-bold mb-3 tracking-wide drop-shadow-md">
                    Préparez-vous pour la 2ᵉ édition !
                </h3>

                <p class="text-sm sm:text-base drop-shadow-md">
                    On prépare la suite avec encore plus de couleurs et de musique !
                    Un peu de patience… la programmation n'est pas encore dévoilée… Elle le sera très bientôt !
                </p>
            </div>
        </div>

        <!-- Timer -->
        <div class="w-full max-w-xs sm:max-w-md md:max-w-lg mx-auto mb-4 sm:mb-6" role="region"
            aria-label="Compte à rebours avant le festival">
            <div id="timer-root"></div>
        </div>

        <!-- Boutons -->
        <div
            class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 m-3 sm:m-6 w-full sm:w-auto max-w-xs sm:max-w-none mx-auto">
            <!-- Bouton "Découvre la programmation" -->
            {{-- <div class="relative w-full sm:w-auto">
                <div class="absolute inset-0 translate-x-1 translate-y-1">
                    <a href="{{ route('programmation') }}"
                        class="relative bg-[#8F1E98] text-[#8F1E98] px-4 sm:px-6 py-3 font-bold uppercase tracking-wide transition duration-300 block w-full text-center">
                        Découvre la programmation →
                    </a>
                </div>
                <a href="{{ route('programmation') }}"
                    class="relative bg-white text-[#8F1E98] px-4 sm:px-6 py-3 font-bold uppercase tracking-wide hover:bg-[#8F1E98] hover:text-white transition duration-300 block w-full text-center">
                    Découvre la programmation →
                </a>
            </div> --}}

            <!-- Bouton "Réserver mes places" -->
            <div class="relative w-full sm:w-auto">
                <div class="absolute inset-0 translate-x-1 translate-y-1">
                    <a href="https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs-26-27-juin-2026"
                        target="_blank" rel="noopener noreferrer"
                        class="relative bg-white px-4 sm:px-6 py-3 font-bold uppercase tracking-wide transition duration-300 block w-full text-center">
                        Réserver mes places →
                    </a>
                </div>
                <a href="https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs-26-27-juin-2026"
                    target="_blank" rel="noopener noreferrer"
                    class="relative bg-[#8F1E98] text-white px-4 sm:px-6 py-3 font-bold uppercase tracking-wide hover:bg-white hover:text-[#8F1E98] transition duration-300 block w-full text-center">
                    Réserver mes places →
                </a>
            </div>
        </div>
    </section>

    {{-- Section FAQ --}}
    {{-- <section aria-labelledby="faq-heading" class="">
        <div id="faq-root" aria-live="polite"></div>
    </section> --}}
@endsection
