<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel = "icon" type = "image/png" href="{{ asset('img/logos/TOUCAN.png') }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calan'Couleurs - Programmation</title>

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
    @vite(['resources/css/app.css', 'resources/js/app.jsx', 'resources/js/navbar-loader.jsx'])


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="w-full">
    <header class="sticky top-0 z-10 bg-white">
        <div id="navbar-root" data-home-url="{{ url('/') }}" data-programmation-url="{{ url('/programmation') }}"
            data-festival-url="{{ url('/notre-histoire') }}" data-contact-url="{{ url('/contact') }}"
            data-billetterie-url="https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs">
        </div>
    </header>
    <main class="w-full pt-16 px-4 py-12 sm:px-6 lg:px-8" id="body-container">
        <h1 class="text-4xl sm:text-5xl text-center font-bold text-[#8F1E98] mb-8">Programmation</h1>

        <section class="w-full" id="onglet-container">
            <div class="border-t border-gray-200 mb-8 overflow-x-auto">
                <!-- Navigation par onglets -->
                <div class="border-b border-gray-200 mb-8 overflow-x-auto">
                    <nav class="tabs flex flex-wrap justify-center space-x-1 sm:space-x-4">
                        <button
                            class="tab py-3 px-4 border-b-2 border-transparent text-[#8F1E98] hover:text-[#FF0F63] font-semibold"
                            data-tab="tab1" aria-selected="false" aria-controls="tab-panel-1">
                            Tous les artistes A à Z
                        </button>
                        <button class="tab active py-3 px-4 border-b-2 border-[#FF0F63] text-[#FF0F63] font-bold"
                            data-tab="tab2" aria-selected="true" aria-controls="tab-panel-2">
                            Vendredi 12
                        </button>
                        <button
                            class="tab py-3 px-4 border-b-2 border-transparent text-[#8F1E98] hover:text-[#FF0F63] font-semibold"
                            data-tab="tab3" aria-selected="false" aria-controls="tab-panel-3">
                            Samedi 13
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Introduction et informations générales -->
            <div class="mb-10 max-w-2xl mx-auto text-center">
                <!-- Description pour l'onglet "Tous les artistes A à Z" -->
                <div id="description-tab1" class="description-panel hidden">
                    <p class="text-lg text-gray-700 mb-4">Découvrez tous les artistes du festival Calan'Couleurs 2025,
                        classés par ordre alphabétique.</p>
                    <div class="flex flex-wrap justify-center gap-4 mt-4">
                        <div class="flex items-center bg-[#FF0F63]/10 px-4 py-2 rounded-full">
                            <span class="inline-block w-4 h-4 bg-[#FF0F63] rounded-full mr-2"></span>
                            <span class="text-sm font-medium text-gray-800">Vendredi 12 juillet</span>
                        </div>
                        <div class="flex items-center bg-[#8F1E98]/10 px-4 py-2 rounded-full">
                            <span class="inline-block w-4 h-4 bg-[#8F1E98] rounded-full mr-2"></span>
                            <span class="text-sm font-medium text-gray-800">Samedi 13 juillet</span>
                        </div>
                    </div>
                </div>

                <!-- Description pour l'onglet "Vendredi 12" -->
                <div id="description-tab2" class="description-panel">
                    <p class="text-lg text-gray-700 mb-4">Le festival Calan'Couleurs vous propose une soirée
                        exceptionnelle vendredi 12 juillet, avec deux scènes pour une expérience musicale variée.</p>
                    <div class="flex flex-wrap justify-center gap-4 mt-4">
                        <div class="flex items-center bg-[#FF0F63]/10 px-4 py-2 rounded-full">
                            <span class="inline-block w-4 h-4 bg-[#FF0F63] rounded-full mr-2"></span>
                            <span class="text-sm font-medium text-gray-800">Scène Extérieure</span>
                        </div>
                        <div class="flex items-center bg-[#8F1E98]/10 px-4 py-2 rounded-full">
                            <span class="inline-block w-4 h-4 bg-[#8F1E98] rounded-full mr-2"></span>
                            <span class="text-sm font-medium text-gray-800">Scène Intérieure</span>
                        </div>
                    </div>
                </div>

                <!-- Description pour l'onglet "Samedi 13" -->
                <div id="description-tab3" class="description-panel hidden">
                    <p class="text-lg text-gray-700 mb-4">Le festival Calan'Couleurs vous propose une journée complète
                        samedi 13 juillet, de l'après-midi jusqu'au bout de la nuit, avec deux scènes pour une
                        expérience musicale variée.</p>
                    <div class="flex flex-wrap justify-center gap-4 mt-4">
                        <div class="flex items-center bg-[#FF0F63]/10 px-4 py-2 rounded-full">
                            <span class="inline-block w-4 h-4 bg-[#FF0F63] rounded-full mr-2"></span>
                            <span class="text-sm font-medium text-gray-800">Scène Extérieure</span>
                        </div>
                        <div class="flex items-center bg-[#8F1E98]/10 px-4 py-2 rounded-full">
                            <span class="inline-block w-4 h-4 bg-[#8F1E98] rounded-full mr-2"></span>
                            <span class="text-sm font-medium text-gray-800">Scène Intérieure</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu des onglets -->
            <div class="tab-contents">
                <!-- Onglet "Tous les artistes" -->
                <div id="tab-panel-1" class="tab-content h-full p-4 hidden" role="tabpanel" aria-labelledby="tab1">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                        <!-- 2TH -->
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/2TH.webp') }}" alt="2TH"
                                    loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">2TH</h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#8F1E98] rounded-full text-xs">SAM
                                            13</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/AN\'OM x VAYN.webp') }}"
                                    alt="An'Om x Vayn" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">An'Om x Vayn</h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#FF0F63] rounded-full text-xs">VEN
                                            12</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/AXLR.webp') }}" alt="AXL R."
                                    loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">AXL R.
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#FF0F63] rounded-full text-xs">VEN
                                            12</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/DJ Hono.webp') }}"
                                    alt="Hono" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">Hono
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#FF0F63] rounded-full text-xs">VEN
                                            12</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/DYMEISTER.webp') }}"
                                    alt="Dymeister" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">Dymeister
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#FF0F63] rounded-full text-xs">VEN
                                            12</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/KABOUM.webp') }}"
                                    alt="Kaboum" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">Kaboum
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#8F1E98] rounded-full text-xs">SAM
                                            13</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/KLÖ.webp') }}" alt="Klö"
                                    loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">Klö
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#8F1E98] rounded-full text-xs">SAM
                                            13</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/LA RIF ET NOS MEN.webp') }}"
                                    alt="La Rif et Nos Men" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">La Rif et Nos Men
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#FF0F63] rounded-full text-xs">VEN
                                            12</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/LEYDON.webp') }}"
                                    alt="Leydon" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">Leydon
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#8F1E98] rounded-full text-xs">SAM
                                            13</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/MAKLOS.webp') }}"
                                    alt="Maklos" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">Maklos
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#8F1E98] rounded-full text-xs">SAM
                                            13</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/MUNE.webp') }}" alt="Mūne"
                                    loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">Mūne
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#8F1E98] rounded-full text-xs">SAM
                                            13</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/ROCK 109.webp') }}"
                                    alt="Rock 109" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">Rock 109
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#FF0F63] rounded-full text-xs">VEN
                                            12</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/TOM WORRF.webp') }}"
                                    alt="TOM WORRF" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">TOM WORRF
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#8F1E98] rounded-full text-xs">SAM
                                            13</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/TRIPIDIUM.webp') }}"
                                    alt="Tripidium" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">Tripidium
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#8F1E98] rounded-full text-xs">SAM
                                            13</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/WAZY.webp') }}" alt="Wazy"
                                    loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">Wazy
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#FF0F63] rounded-full text-xs">VEN
                                            12</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/YONEX.webp') }}"
                                    alt="Yonex" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">Yonex
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#8F1E98] rounded-full text-xs">SAM
                                            13</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="artist-card group">
                            <div
                                class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                <img src="{{ asset('img/artists/photos/Photos_artistes/YOUTH COLLECTIVE.webp') }}"
                                    alt="Youth Collective" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute bottom-0 left-0 right-0 p-3"
                                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                    <h3 class="text-white font-bold">Youth Collective
                                    </h3>
                                    <p class="text-white text-xs">
                                        <span class="inline-block px-2 py-1 bg-[#8F1E98] rounded-full text-xs">SAM
                                            13</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Onglet "Vendredi 12" avec timeline -->
                <div id="tab-panel-2" class="tab-content h-full p-4" role="tabpanel" aria-labelledby="tab2">
                    <div class="relative border-l-2 border-gray-200 ml-4 sm:mx-auto max-w-5xl">
                        <!-- Timeline 20h-22h30 -->
                        <div class="mb-12">
                            <div class="flex items-center mb-4">
                                <div
                                    class="bg-[#8F1E98] rounded-full w-10 h-10 flex items-center justify-center -ml-5 shadow-lg">
                                    <span class="text-white font-bold text-xs">20h</span>
                                </div>
                                <h3 class="text-lg font-bold ml-2 text-[#8F1E98]">Début de soirée</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pl-6">
                                <!-- Rock 109 -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#FF0F63] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Extérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/ROCK 109.webp') }}"
                                            alt="Rock 109" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">Rock 109</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>VEN 12</span>
                                                <span class="font-medium">20h - 21h30</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- La Rif Et Nos Men -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#8F1E98] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                                </svg>
                                                Intérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/LA RIF ET NOS MEN.webp') }}"
                                            alt="La Rif et Nos Men" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">La Rif et Nos Men</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>VEN 12</span>
                                                <span class="font-medium">21h - 22h30</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline 22h30-00h -->
                        <div class="mb-12">
                            <div class="flex items-center mb-4">
                                <div
                                    class="bg-[#8F1E98] rounded-full w-10 h-10 flex items-center justify-center -ml-5 shadow-lg">
                                    <span class="text-white font-bold text-xs">22h30</span>
                                </div>
                                <h3 class="text-lg font-bold ml-2 text-[#8F1E98]">Milieu de soirée</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pl-6">
                                <!-- An'Om x Vayn (ajoutez cette carte d'artiste selon vos données) -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#FF0F63] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Extérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/AN\'OM x VAYN.webp') }}"
                                            alt="An'Om x Vayn" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">An'Om x Vayn</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>VEN 12</span>
                                                <span class="font-medium">22h30 - 00h</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline 00h-02h -->
                        <div class="mb-12">
                            <div class="flex items-center mb-4">
                                <div
                                    class="bg-[#8F1E98] rounded-full w-10 h-10 flex items-center justify-center -ml-5 shadow-lg">
                                    <span class="text-white font-bold text-xs">00h</span>
                                </div>
                                <h3 class="text-lg font-bold ml-2 text-[#8F1E98]">Soirée</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pl-6">
                                <!-- WAZY -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#FF0F63] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Extérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/WAZY.webp') }}"
                                            alt="Wazy" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">Wazy</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>VEN 12</span>
                                                <span class="font-medium">00h - 02h</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- AXL.R -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#8F1E98] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                                </svg>
                                                Intérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/AXLR.webp') }}"
                                            alt="AXL R." loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">AXL R.</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>VEN 12</span>
                                                <span class="font-medium">00h30 - 02h</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline 02h-04h -->
                        <div class="mb-12">
                            <div class="flex items-center mb-4">
                                <div
                                    class="bg-[#8F1E98] rounded-full w-10 h-10 flex items-center justify-center -ml-5 shadow-lg">
                                    <span class="text-white font-bold text-xs">02h</span>
                                </div>
                                <h3 class="text-lg font-bold ml-2 text-[#8F1E98]">Fin de soirée</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pl-6">
                                <!-- DJ Hono -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#FF0F63] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Extérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/DJ Hono.webp') }}"
                                            alt="Hono" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">Hono</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>VEN 12</span>
                                                <span class="font-medium">02h - 04h</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dymeister -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#8F1E98] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                                </svg>
                                                Intérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/DYMEISTER.webp') }}"
                                            alt="Dymeister" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">Dymeister</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>VEN 12</span>
                                                <span class="font-medium">02h - 03h30</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Onglet "Samedi 13" avec timeline similaire -->
                <div id="tab-panel-3" class="tab-content h-full p-4 hidden" role="tabpanel" aria-labelledby="tab3">
                    <div class="relative border-l-2 border-gray-200 ml-4 sm:mx-auto max-w-5xl">
                        <!-- Timeline 15h-19h30 -->
                        <div class="mb-12">
                            <div class="flex items-center mb-4">
                                <div
                                    class="bg-[#8F1E98] rounded-full w-10 h-10 flex items-center justify-center -ml-5 shadow-lg">
                                    <span class="text-white font-bold text-xs">15h</span>
                                </div>
                                <h3 class="text-lg font-bold ml-2 text-[#8F1E98]">Après-midi festif</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pl-6">
                                <!-- Youth Collective -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#FF0F63] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Extérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/YOUTH COLLECTIVE.webp') }}"
                                            alt="Youth Collective" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">Youth Collective</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>SAM 13</span>
                                                <span class="font-medium">15h - 17h</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Maklos -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#FF0F63] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Extérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/MAKLOS.webp') }}"
                                            alt="Maklos" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">Maklos</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>SAM 13</span>
                                                <span class="font-medium">17h - 18h30</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Klö -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#FF0F63] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Extérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/KLÖ.webp') }}"
                                            alt="Klö" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">Klö</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>SAM 13</span>
                                                <span class="font-medium">18h30 - 19h30</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline 19h30-22 -->
                        <div class="mb-12">
                            <div class="flex items-center mb-4">
                                <div
                                    class="bg-[#8F1E98] rounded-full w-10 h-10 flex items-center justify-center -ml-5 shadow-lg">
                                    <span class="text-white font-bold text-xs">19h30</span>
                                </div>
                                <h3 class="text-lg font-bold ml-2 text-[#8F1E98]">Début de soirée</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pl-6">
                                <!-- Kaboum -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#FF0F63] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Extérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/KABOUM.webp') }}"
                                            alt="Kaboum" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">Kaboum</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>SAM 13</span>
                                                <span class="font-medium">19h30 - 21h</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- TOM WORRF -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#8F1E98] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                                </svg>
                                                Intérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/TOM WORRF.webp') }}"
                                            alt="TOM WORRF" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">TOM WORRF</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>SAM 13</span>
                                                <span class="font-medium">20h30 - 22h</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline 22h-02h -->
                        <div class="mb-12">
                            <div class="flex items-center mb-4">
                                <div
                                    class="bg-[#8F1E98] rounded-full w-10 h-10 flex items-center justify-center -ml-5 shadow-lg">
                                    <span class="text-white font-bold text-xs">22h</span>
                                </div>
                                <h3 class="text-lg font-bold ml-2 text-[#8F1E98]">Soirée</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pl-6">
                                <!-- 2TH -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#FF0F63] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Extérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/2TH.webp') }}"
                                            alt="2TH" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">2TH</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>SAM 13</span>
                                                <span class="font-medium">22h - 23h30</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mūne -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#FF0F63] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Extérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/MUNE.webp') }}"
                                            alt="Mūne" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">Mūne</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>SAM 13</span>
                                                <span class="font-medium">23h30 - 02h</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Yonex -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#8F1E98] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                                </svg>
                                                Intérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/YONEX.webp') }}"
                                            alt="Yonex" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">Yonex</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>SAM 13</span>
                                                <span class="font-medium">00h30 - 02h</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline 02h-04h -->
                        <div class="mb-12">
                            <div class="flex items-center mb-4">
                                <div
                                    class="bg-[#8F1E98] rounded-full w-10 h-10 flex items-center justify-center -ml-5 shadow-lg">
                                    <span class="text-white font-bold text-xs">02h</span>
                                </div>
                                <h3 class="text-lg font-bold ml-2 text-[#8F1E98]">Fin de soirée</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pl-6">
                                <!-- Leydon -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#FF0F63] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Extérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/LEYDON.webp') }}"
                                            alt="Leydon" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">Leydon</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>SAM 13</span>
                                                <span class="font-medium">02h - 04h</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tripidium -->
                                <div class="artist-card group">
                                    <div
                                        class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
                                        <div class="absolute -top-1 right-0 z-1">
                                            <span
                                                class="inline-block px-3 py-1 bg-[#8F1E98] text-white text-xs font-bold rounded-bl-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                                </svg>
                                                Intérieure
                                            </span>
                                        </div>
                                        <img src="{{ asset('img/artists/photos/Photos_artistes/TRIPIDIUM.webp') }}"
                                            alt="Tripidium" loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 p-3"
                                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                            <h3 class="text-white font-bold">Tripidium</h3>
                                            <p class="text-white text-xs flex items-center justify-between">
                                                <span>SAM 13</span>
                                                <span class="font-medium">02h - 03h30</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>
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
<script>
    // Modification du script pour gérer les panneaux de description
    const tabs = document.querySelectorAll('.tabs .tab');
    const contents = document.querySelectorAll('.tab-contents .tab-content');
    const descriptions = document.querySelectorAll('.description-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const tabId = this.getAttribute('aria-controls');
            const target = document.getElementById(tabId);
            const tabNumber = this.getAttribute('data-tab');
            const descriptionTarget = document.getElementById('description-' + tabNumber);

            // Remove 'active' class from all tabs
            tabs.forEach(t => {
                t.classList.remove('active', 'border-b-2', 'border-[#FF0F63]', 'text-[#FF0F63]',
                    'font-bold');
                t.classList.add('border-transparent', 'text-[#8F1E98]', 'hover:text-[#FF0F63]',
                    'font-semibold');
                t.setAttribute('aria-selected', 'false');
            });

            // Hide all tab contents and descriptions
            contents.forEach(c => c.classList.add('hidden'));
            descriptions.forEach(d => d.classList.add('hidden'));

            // Add 'active' class to the clicked tab
            this.classList.add('active', 'border-b-2', 'border-[#FF0F63]', 'text-[#FF0F63]',
                'font-bold');
            this.classList.remove('border-transparent', 'text-[#8F1E98]', 'hover:text-[#FF0F63]',
                'font-semibold');
            this.setAttribute('aria-selected', 'true');

            // Show the corresponding tab content and description
            if (target) {
                target.classList.remove('hidden');
            }

            if (descriptionTarget) {
                descriptionTarget.classList.remove('hidden');
            }
        });
    });
</script>

</html>
