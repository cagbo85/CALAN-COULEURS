@extends('layouts.app')

@section('title', 'Calan\'Couleurs Festival ' . $currentEdition->year . ' à Campbon | Musique, Artistes & Billetterie')

@section('meta')
    <meta name="google-site-verification" content="3j2RcHRKc1fefLWwLlGVFZWlAqh6XvK741ZMDtz1LKA" />
    <meta name="description"
        content="Calan'Couleurs Festival - {{ $currentEdition->formatted_dates_2 }} à Campbon. Découvrez la programmation, achetez vos billets et rejoignez-nous pour un week-end inoubliable de musique et de convivialité." />
    <meta name="keywords" content="Calan'Couleurs, Calan Couleurs, Festival, musique, Campbon, programmation, billets" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Calan'Couleurs Team" />
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />

    <meta property="og:title" content="CALAN-COULEURS | Festival musical à Campbon" />
    <meta property="og:description"
        content="Festival les {{ $currentEdition->formatted_dates_2 }} à Campbon. Programmation, billets, infos pratiques." />
    <meta property="og:image" content="https://calan-couleurs.fr/img/logos/accueil_public.png" />
    <meta property="og:url" content="https://calan-couleurs.fr/" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="CALAN-COULEURS | Festival musical à Campbon" />
    <meta name="twitter:description"
        content="Un week-end de musique et de festivités à Campbon les {{ $currentEdition->formatted_dates_2 }}." />
    <meta name="twitter:image" content="https://calan-couleurs.fr/img/logos/accueil_public.png" />
@endsection

@push('scripts')
    @vite(['resources/js/timer-loader.jsx', 'resources/js/stands-loader.jsx', 'resources/js/faq-loader.jsx', 'resources/js/programmation-loader.jsx'])
@endpush

@section('content')
    <!-- Matomo -->
    <script>
    var _paq = window._paq = window._paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="https://calancouleurs.matomo.cloud/";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', '1']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.async=true; g.src='https://cdn.matomo.cloud/calancouleurs.matomo.cloud/matomo.js'; s.parentNode.insertBefore(g,s);
    })();
    </script>
    <section
        class="min-h-[500px] sm:h-[calc(100vh-64px)] w-full px-2 sm:px-4 py-8 flex flex-col justify-center items-center bg-[url('/img/logos/accueil_public.png')] bg-no-repeat bg-center bg-cover text-center">

        <!-- Dates du festival -->
        @if ($currentEdition)
            <div class="px-4 py-2 mb-3 border shadow-lg sm:mb-4 backdrop-blur-md sm:px-8 sm:py-3 rounded-xl border-white/50"
                style="background: linear-gradient(180deg, rgba(39,42,199,0.35), rgba(39,42,199,0.22), rgba(143,30,152,0.14));">
                <h2 class="text-lg font-bold tracking-wider text-white sm:text-xl md:text-2xl drop-shadow-md">
                    {{ $currentEdition->formatted_dates }}
                </h2>
            </div>
        @endif

        <!-- Timer -->
        <div class="w-full max-w-xs mx-auto mb-4 sm:max-w-md md:max-w-lg sm:mb-6" role="region"
            aria-label="Compte à rebours avant le festival">
            <div id="timer-root"></div>
        </div>

        <!-- Edition et lieu -->
        @if ($currentEdition)
            <div class="px-4 py-2 mt-1 mb-4 border shadow-lg sm:mt-2 sm:mb-6 backdrop-blur-md sm:px-6 sm:py-3 rounded-xl border-white/30"
                style="background: linear-gradient(180deg, rgba(39,42,199,0.35), rgba(39,42,199,0.22), rgba(143,30,152,0.14));">
                <p class="text-base font-bold tracking-wide text-white sm:text-xl drop-shadow-sm">
                    {{ strtoupper($currentEdition->name) ?? 'Édition ' . $currentEdition->year }} - CAMPBON
                </p>
            </div>
        @endif

        <!-- Boutons -->
        <div
            class="flex flex-col w-full max-w-xs m-3 mx-auto space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4 sm:m-6 sm:w-auto sm:max-w-none">
            <!-- Bouton "Découvre la programmation" -->
            <div class="relative w-full sm:w-auto">
                <div class="absolute inset-0 translate-x-1 translate-y-1">
                    <a href="{{ route('programmation') }}"
                        class="relative bg-[#272AC7] text-[#272AC7] px-4 sm:px-6 py-3 font-bold uppercase tracking-wide transition duration-300 block w-full text-center">
                        Découvre la programmation <i class="fa-solid fa-arrow-right fa-xs"></i>
                    </a>
                </div>
                <a href="{{ route('programmation') }}"
                    class="relative bg-white text-[#272AC7] px-4 sm:px-6 py-3 font-bold uppercase tracking-wide hover:bg-[#272AC7] hover:text-white transition duration-300 block w-full text-center">
                    Découvre la programmation <i class="fa-solid fa-arrow-right fa-xs"></i>
                </a>
            </div>

            <!-- Bouton "Acheter des billets" -->
            <div class="relative w-full sm:w-auto">
                <div class="absolute inset-0 translate-x-1 translate-y-1">
                    <a href="{{ $currentEdition->reservation_url }}"
                        target="_blank" rel="noopener noreferrer"
                        class="relative block w-full px-4 py-3 font-bold tracking-wide text-center uppercase transition duration-300 bg-white sm:px-6">
                        Acheter des billets <i class="fa-solid fa-arrow-right fa-xs"></i>
                    </a>
                </div>
                <a href="{{ $currentEdition->reservation_url }}"
                    target="_blank" rel="noopener noreferrer"
                    class="relative bg-[#272AC7] text-white px-4 sm:px-6 py-3 font-bold uppercase tracking-wide hover:bg-white hover:text-[#272AC7] transition duration-300 block w-full text-center">
                    Acheter des billets <i class="fa-solid fa-arrow-right fa-xs"></i>
                </a>
            </div>
        </div>
    </section>
    <main>
        {{-- Section Programme --}}
        <section aria-labelledby="programmation-heading" class="">
            <div id="programmation-root" aria-live="polite"></div>
        </section>

        {{-- Section Stands --}}
        <section aria-labelledby="stands-heading" class="">
            <div id="stands-root" aria-live="polite"></div>
        </section>

        {{-- Section FAQ --}}
        <section aria-labelledby="faq-heading" class="">
            <div id="faq-root" aria-live="polite"></div>
        </section>
    </main>
@endsection
