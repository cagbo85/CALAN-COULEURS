<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="3j2RcHRKc1fefLWwLlGVFZWlAqh6XvK741ZMDtz1LKA" />
    <meta name="description"
        content="Calan'Couleurs Festival - 12 & 13 septembre 2025 à Campbon. Découvrez la programmation, achetez vos billets et rejoignez-nous pour un week-end inoubliable de musique et de convivialité." />
    <meta name="keywords"
        content="Calan'Couleurs, Calan Couleurs, Festival, musique, Campbon, programmation, billets" />
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

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/png" href="/img/logos/TOUCAN.png">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calan'Couleurs Festival 2025 à Campbon | Musique, Artistes & Billetterie</title>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'urbanist': ['Urbanist', 'sans-serif'],
                        'urbanist-bold': ['Urbanist Bold', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx', 'resources/js/navbar-loader.jsx', 'resources/js/timer-loader.jsx', 'resources/js/onsite-loader.jsx', 'resources/js/faq-loader.jsx'])


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="w-full">
    <header class="sticky top-0 z-10 bg-white">
        <div id="navbar-root" data-home-url="{{ url('/') }}" data-programmation-url="{{ url('/programmation') }}"
            data-festival-url="{{ url('/notre-histoire') }}" data-contact-url="{{ url('/contact') }}"
            data-billetterie-url="https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs">
        </div>
    </header>
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
    {{-- Footer --}}
    <footer class="bg-[#8F1E98] text-white py-12">
        <div class="container mx-auto px-6">
            {{-- Section supérieure avec logo et navigation --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                {{-- Logo --}}
                <div class="mb-6 md:mb-0">
                    <img href="/" src="/img/logos/LOGO/Logo-Calan-blanc.png" alt="Logo Calan'Couleurs"
                        class="h-16">
                </div>

                {{-- Navigation --}}
                <nav class="flex flex-col sm:flex-row gap-3 sm:gap-8 text-center sm:text-left">
                    <a href="/"
                        class="text-white hover:text-[#FF0F63] font-medium transition duration-300">Accueil</a>
                    <a href="{{ route('festival') }}"
                        class="text-white hover:text-[#FF0F63] font-medium transition duration-300">Le Festival</a>
                    <a href="{{ route('programmation') }}"
                        class="text-white hover:text-[#FF0F63] font-medium transition duration-300">Programmation</a>
                    <a href="https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs"
                        target="_blank" rel="noopener noreferrer"
                        class="text-white hover:text-[#FF0F63] font-medium transition duration-300">Billeterie</a>
                    {{-- <a href="#" class="text-white hover:text-[#FF0F63] font-medium transition duration-300">À Propos</a> --}}
                    {{-- <a href="#" class="text-white hover:text-[#FF0F63] font-medium transition duration-300">Contact</a> --}}
                </nav>
            </div>

            {{-- Ligne séparatrice --}}
            <hr class="border-white/20 my-8">

            {{-- Section inférieure avec réseaux sociaux et mentions légales --}}
            <div class="flex flex-col md:flex-row justify-between items-center">
                {{-- Réseaux sociaux --}}
                <div class="flex space-x-6 mb-6 md:mb-0">
                    <a href="https://www.instagram.com/calancouleurs/" target="_blank" rel="noopener noreferrer"
                        class="text-white hover:text-[#FF0F63] transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor" class="w-6 h-6">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=61555539331779" target="_blank"
                        rel="noopener noreferrer" class="text-white hover:text-[#FF0F63] transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor" class="w-6 h-6">
                            <path
                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                        </svg>
                    </a>
                </div>

                {{-- Copyright et mentions légales --}}
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-6 text-center sm:text-right">
                    <span class="text-sm text-white/70">© 2025 Calan'Couleurs. Tous droits réservés</span>
                    {{-- <a href="#" class="text-sm text-white/70 hover:text-white transition duration-300">Mentions légales</a>
                <a href="#" class="text-sm text-white/70 hover:text-white transition duration-300">Politique de confidentialité</a> --}}
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
