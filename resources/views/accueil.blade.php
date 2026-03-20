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
    <section
        class="min-h-[500px] sm:h-[calc(100vh-64px)] w-full px-2 sm:px-4 py-8 flex flex-col justify-center items-center bg-[url('/img/logos/accueil_public.png')] bg-no-repeat bg-center bg-cover text-center">

        <!-- Dates du festival -->
        @if ($currentEdition)
            <div class="mb-3 sm:mb-4 backdrop-blur-md shadow-lg px-4 sm:px-8 py-2 sm:py-3 rounded-xl border border-white/50"
                style="background: linear-gradient(180deg, rgba(255,15,99,0.2), rgba(143,30,152,0.2), rgba(39,42,199,0.2));">
                <h2 class="text-white text-lg sm:text-xl md:text-2xl font-bold tracking-wider drop-shadow-md">
                    {{ $currentEdition->formatted_dates }}
                </h2>
            </div>
        @endif

        <!-- Timer -->
        <div class="w-full max-w-xs sm:max-w-md md:max-w-lg mx-auto mb-4 sm:mb-6" role="region"
            aria-label="Compte à rebours avant le festival">
            <div id="timer-root"></div>
        </div>

        <!-- Edition et lieu -->
        @if ($currentEdition)
            <div class="mt-1 sm:mt-2 mb-4 sm:mb-6 backdrop-blur-md px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg border border-white/30"
                style="background: linear-gradient(180deg, rgba(255,15,99,0.2), rgba(143,30,152,0.2), rgba(39,42,199,0.2));">
                <p class="text-white font-bold text-base sm:text-xl tracking-wide drop-shadow-sm">
                    {{ strtoupper($currentEdition->name) ?? 'Édition ' . $currentEdition->year }} - CAMPBON
                </p>
            </div>
        @endif

        <!-- Boutons -->
        <div
            class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 m-3 sm:m-6 w-full sm:w-auto max-w-xs sm:max-w-none mx-auto">
            <!-- Bouton "Découvre la programmation" -->
            <div class="relative w-full sm:w-auto">
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
            </div>

            <!-- Bouton "Acheter des billets" -->
            <div class="relative w-full sm:w-auto">
                <div class="absolute inset-0 translate-x-1 translate-y-1">
                    <a href="{{ $currentEdition->reservation_url }}"
                        target="_blank" rel="noopener noreferrer"
                        class="relative bg-white px-4 sm:px-6 py-3 font-bold uppercase tracking-wide transition duration-300 block w-full text-center">
                        Acheter des billets →
                    </a>
                </div>
                <a href="{{ $currentEdition->reservation_url }}"
                    target="_blank" rel="noopener noreferrer"
                    class="relative bg-[#8F1E98] text-white px-4 sm:px-6 py-3 font-bold uppercase tracking-wide hover:bg-white hover:text-[#8F1E98] transition duration-300 block w-full text-center">
                    Acheter des billets →
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
