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
    @vite(['resources/js/timer-loader.jsx', 'resources/js/stands-loader.jsx', 'resources/js/faq-loader.jsx'])
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
        <div class="w-full max-w-xs sm:max-w-md md:max-w-lg mx-auto mb-4 sm:mb-6" role="region"
            aria-label="Compte à rebours avant le festival">
            <div id="timer-root"></div>
        </div>

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
            style="background: linear-gradient(180deg, rgba(255,15,99,0.9) 0%, rgba(143,30,152,0.9) 35%, rgba(39,42,199,0.9) 100%)"
            aria-labelledby="programmation-heading">
            <div class="container mx-auto">
                <h2 id="programmation-heading"
                    class="text-3xl text-white font-bold uppercase mb-10 text-center sm:text-left">La programmation</h2>

                <div class="flex flex-wrap justify-center gap-8 max-w-6xl mx-auto">
                    <!-- Jour 1 - Vendredi -->
                    <section
                        class="w-[20rem] h-[35rem] min-h-[24rem] bg-cover bg-center text-white p-6 flex flex-col justify-between border-2 border-white shadow-lg"
                        style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.1))"
                        aria-labelledby="vendredi-title">
                        <div>
                            <h3 id="vendredi-title" class="text-xl font-bold">Vendredi 12 septembre</h3>
                            <p class="text-sm font-bold text-white/80">
                                <time datetime="2025-09-12T20:00">20h</time> – <time datetime="2025-09-13T04:00">4h</time>
                            </p>
                        </div>

                        <ul class="space-y-3 mt-4" aria-label="Ordre de passage">
                            <li class="text-lg font-bold uppercase tracking-wide">Rock 109</li>
                            <li class="text-lg font-bold uppercase tracking-wide">La Rif et Nos Men</li>
                            <li class="text-lg font-bold uppercase tracking-wide">An'Om x Vayn</li>
                            <li class="text-lg font-bold uppercase tracking-wide">Wazy</li>
                            <li class="text-lg font-bold uppercase tracking-wide">AXL R.</li>
                            <li class="text-lg font-bold uppercase tracking-wide">Hono</li>
                            <li class="text-lg font-bold uppercase tracking-wide">Dymeister</li>
                        </ul>
                    </section>

                    <!-- Jour 2 - Samedi -->
                    <section
                        class="w-[20rem] h-[35rem] min-h-[24rem] bg-cover bg-center text-white p-6 flex flex-col justify-between border-2 border-white shadow-lg"
                        style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.1))"
                        aria-labelledby="samedi-title">
                        <div>
                            <h3 id="samedi-title" class="text-xl font-bold">Samedi 13 septembre</h3>
                            <p class="text-sm font-bold text-white/80">
                                <time datetime="2025-09-13T15:00">15h</time> – <time datetime="2025-09-14T04:00">4h</time>
                            </p>
                        </div>

                        <ul class="space-y-3 mt-4" aria-label="Ordre de passage">
                            <li class="text-lg font-bold uppercase tracking-wide">Youth Collective</li>
                            <li class="text-lg font-bold uppercase tracking-wide">Maklos</li>
                            <li class="text-lg font-bold uppercase tracking-wide">Klö</li>
                            <li class="text-lg font-bold uppercase tracking-wide">Kaboum</li>
                            <li class="text-lg font-bold uppercase tracking-wide">TOM WORRF</li>
                            <li class="text-lg font-bold uppercase tracking-wide">2TH</li>
                            <li class="text-lg font-bold uppercase tracking-wide">Mūne</li>
                            <li class="text-lg font-bold uppercase tracking-wide">Yonex</li>
                            <li class="text-lg font-bold uppercase tracking-wide">Leydon</li>
                            <li class="text-lg font-bold uppercase tracking-wide">Tripidium</li>
                        </ul>
                    </section>
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('programmation') }}"
                        class="inline-block px-8 py-3 text-center mt-2 bg-[#8F1E98] text-white font-semibold rounded-lg hover:bg-[#FF0F63] transition focus:outline-none focus-visible:ring">
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
        <section aria-labelledby="stands-heading" class="">
            <div id="stands-root" aria-live="polite"></div>
        </section>

        {{-- Section FAQ --}}
        <section aria-labelledby="faq-heading" class="">
            <div id="faq-root" aria-live="polite"></div>
        </section>
    </main>
@endsection
