@extends('layouts.app')

@section('title', 'Calan\'Couleurs Festival 2025 à Campbon | Musique, Artistes & Billetterie')

@section('meta')
    <meta name="google-site-verification" content="3j2RcHRKc1fefLWwLlGVFZWlAqh6XvK741ZMDtz1LKA" />
    <meta name="description"
        content="Calan'Couleurs Festival - 12 & 13 septembre 2025 à Campbon. Découvrez la programmation, achetez vos billets et rejoignez-nous pour un week-end inoubliable de musique et de convivialité." />
    <meta name="keywords" content="Calan'Couleurs, Calan Couleurs, Festival, musique, Campbon, programmation, billets" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Calan'Couleurs Team" />
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />

    <meta property="og:title" content="CALAN-COULEURS | Festival musical à Campbon" />
    <meta property="og:description"
        content="Festival les 12 & 13 septembre 2025 à Campbon. Programmation, billets, infos pratiques." />
    <meta property="og:image" content="https://calan-couleurs.fr/img/logos/accueil_public.png" />
    <meta property="og:url" content="https://calan-couleurs.fr/" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="CALAN-COULEURS | Festival musical à Campbon" />
    <meta name="twitter:description"
        content="Un week-end de musique et de festivités à Campbon les 12 & 13 septembre 2025." />
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
                VENDREDI 12 & SAMEDI 13 SEPTEMBRE 2025
            </h2>
        </div>

        <!-- Timer -->
        <div id="timer-root" class="w-full max-w-xs sm:max-w-md md:max-w-lg mx-auto mb-4 sm:mb-6"></div>

        <!-- Edition et lieu -->
        <div class="mt-1 sm:mt-2 mb-4 sm:mb-6 backdrop-blur-md px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg border border-white/30"
            style="background: linear-gradient(180deg, rgba(255,15,99,0.2), rgba(143,30,152,0.2), rgba(39,42,199,0.2));">
            <p class="text-white font-bold text-base sm:text-xl tracking-wide drop-shadow-sm">1<sup>ère</sup> ÉDITION À
                CAMPBON</p>
        </div>

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
                    <a href="https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs"
                        target="_blank" rel="noopener noreferrer"
                        class="relative bg-white px-4 sm:px-6 py-3 font-bold uppercase tracking-wide transition duration-300 block w-full text-center">
                        Acheter des billets →
                    </a>
                </div>
                <a href="https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs"
                    target="_blank" rel="noopener noreferrer"
                    class="relative bg-[#8F1E98] text-white px-4 sm:px-6 py-3 font-bold uppercase tracking-wide hover:bg-white hover:text-[#8F1E98] transition duration-300 block w-full text-center">
                    Acheter des billets →
                </a>
            </div>
        </div>
    </section>
    {{-- Section programme --}}
    <main>
        {{-- Section programme --}}
        <section class="py-16 px-6"
            style="background: linear-gradient(180deg, rgba(255,15,99,0.9) 0%, rgba(143,30,152,0.9) 35%, rgba(39,42,199,0.9) 100%)">
            <div class="container mx-auto">
                <h2 class="text-3xl text-white font-bold uppercase mb-10 text-center sm:text-left">La programmation</h2>

                <div class="flex flex-wrap justify-center gap-8 max-w-6xl mx-auto">
                    <!-- Jour 1 - Vendredi -->
                    <div class="w-[20rem] h-[35rem] min-h-[24rem] bg-cover bg-center text-white p-6 flex flex-col justify-between border-2 border-white shadow-lg"
                        style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.1))">

                        <div class="space-y-3">
                            <!-- Artistes dans l'ordre de passage -->
                            <p class="text-lg font-bold uppercase tracking-wide">Rock 109</p>
                            <p class="text-lg font-bold uppercase tracking-wide">La Rif et Nos Men</p>
                            <p class="text-lg font-bold uppercase tracking-wide">An'Om x Vayn</p>
                            <p class="text-lg font-bold uppercase tracking-wide">Wazy</p>
                            <p class="text-lg font-bold uppercase tracking-wide">AXL R.</p>
                            <p class="text-lg font-bold uppercase tracking-wide">Hono</p>
                            <p class="text-lg font-bold uppercase tracking-wide">Dymeister</p>
                        </div>

                        <div>
                            <p class="text-xl font-bold text-white mt-4">Vendredi 12 septembre</p>
                            <p class="text-sm font-bold text-white opacity-80">20h à 4h</p>
                        </div>
                    </div>

                    <!-- Jour 2 - Samedi -->
                    <div class="w-[20rem] h-[35rem] min-h-[24rem] bg-cover bg-center text-white p-6 flex flex-col justify-between border-2 border-white shadow-lg"
                        style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.1))">

                        <div class="space-y-3">
                            <!-- Artistes dans l'ordre de passage -->
                            <p class="text-lg font-bold uppercase tracking-wide">Youth Collective</p>
                            <p class="text-lg font-bold uppercase tracking-wide">Maklos</p>
                            <p class="text-lg font-bold uppercase tracking-wide">Klö</p>
                            <p class="text-lg font-bold uppercase tracking-wide">Kaboum</p>
                            <p class="text-lg font-bold uppercase tracking-wide">TOM WORRF</p>
                            <p class="text-lg font-bold uppercase tracking-wide">2TH</p>
                            <p class="text-lg font-bold uppercase tracking-wide">Mūne</p>
                            <p class="text-lg font-bold uppercase tracking-wide">Yonex</p>
                            <p class="text-lg font-bold uppercase tracking-wide">Leydon</p>
                            <p class="text-lg font-bold uppercase tracking-wide">Tripidium</p>
                        </div>

                        <div>
                            <p class="text-xl font-bold text-white mt-4">Samedi 13 septembre</p>
                            <p class="text-sm font-bold text-white opacity-80">15h à 4h</p>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('programmation') }}"
                        class="inline-block px-8 py-3 text-center mt-2 bg-[#8F1E98] text-white font-semibold rounded-lg hover:bg-[#FF0F63] transition">
                        Voir les horaires détaillés
                    </a>
                </div>
            </div>
        </section>
        {{--
        <section class="py-16">
            <div id="program-root"></div>
        </section> --}}

        {{-- Section carousel --}}
        {{-- <section class="">
            <div id="carousel-root"></div>
        </section> --}}

        {{-- Section Artistes --}}
        {{-- <section class="py-16">
            <div id="artist-root"></div>
        </section> --}}

        {{-- Section Onsite --}}
        <section class="">
            <div id="onsite-root"></div>
        </section>

        {{-- Section FAQ --}}
        <section class="">
            <div id="faq-root"></div>
        </section>
    </main>
@endsection
