@extends('layouts.app')

@section('title', 'Notre histoire - Calan\'Couleurs ' . $currentEdition->year)

@section('content')
    <div class="w-full min-h-screen bg-[#EEF1FF]">

        <!-- Hero -->
        <section
            class="relative w-full min-h-[560px] sm:min-h-[650px] bg-cover bg-center bg-no-repeat flex items-center justify-center"
            style="background-image:
            linear-gradient(rgba(29,63,137,0.84), rgba(119,203,243,0.42)),
            url('/img/festival/banner.jpg');">
            <div class="px-4 text-center">
                <h1 class="mb-4 text-5xl font-bold text-white sm:text-6xl md:text-7xl drop-shadow-lg">
                    Calan'Couleurs
                </h1>
                <p class="text-lg font-semibold sm:text-2xl text-white/95 drop-shadow-md">
                    {{ $currentEdition->formatted_dates_2 }}
                </p>
            </div>
        </section>

        <!-- Intro -->
        <section class="px-4 sm:px-6 lg:px-8 py-14">
            <div class="mx-auto max-w-7xl">
                <div class="mb-10 text-center">
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#1d3f89] mb-4">Notre histoire</h2>
                    <p class="max-w-3xl mx-auto text-lg text-gray-600">
                        Un festival créé par des passionnés, pour faire vibrer le territoire et rassembler toutes les
                        générations.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">

                    <!-- Histoire -->
                    <article class="overflow-hidden bg-white border border-[#1d3f89]/15 shadow-sm rounded-xl">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #1d3f89 0%, #77cbf3 100%);">
                            <h3 class="text-xl font-semibold text-white">Pourquoi Calan'Couleurs ?</h3>
                        </div>
                        <div class="p-6 space-y-5 leading-relaxed text-gray-700">
                            <p>
                                Nous sommes une bande de copains passionnés de musique et attachés à notre territoire. Pour
                                faire vivre la scène locale, créer du lien et partager un moment festif, nous avons lancé
                                Calan'Couleurs, un festival qui nous ressemble.
                            </p>
                            <p>
                                L'idée est simple : proposer une ambiance conviviale, ouverte à tous, où se rencontrent
                                artistes émergents et confirmés, autour d'une programmation vivante et accessible.
                            </p>
                        </div>
                    </article>

                    <!-- Edition -->
                    <article class="overflow-hidden bg-white border border-[#1d3f89]/15 shadow-sm rounded-xl">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #1d3f89 0%, #77cbf3 100%);">
                            <h3 class="text-xl font-semibold text-white">Cette édition {{ $currentEdition->year }}</h3>
                        </div>
                        <div class="p-6 space-y-5 leading-relaxed text-gray-700">
                            <p>
                                Rendez-vous les {{ $currentEdition->formatted_dates_2 }} à Campbon (44750)
                                pour une {{ $currentEdition->edition_label }} haute en couleur.
                            </p>
                            <p>
                                Au programme : concerts, rencontres, émotions, et surtout une énergie collective
                                qui fait l'ADN du festival depuis le début.
                            </p>

                            <div class="pt-2">
                                <a href="{{ route('programmation') }}"
                                    class="inline-block px-4 py-2 font-semibold text-white transition-all duration-300 transform rounded-lg shadow-lg bg-[#1d3f89] hover:bg-[#152E66] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#1d3f89] hover:shadow-xl hover:-translate-y-0.5"
                                    style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%);">
                                    Découvrir la programmation <i class="fa-solid fa-arrow-right fa-xs"></i>
                                </a>
                            </div>
                        </div>
                    </article>

                </div>
            </div>
        </section>

        <!-- Valeurs -->
        <section class="px-4 sm:px-6 lg:px-8 pb-14">
            <div class="mx-auto max-w-7xl">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="bg-white border border-[#1d3f89]/15 rounded-xl p-6 shadow-sm">
                        <h4 class="font-bold text-[#1d3f89] mb-2">🎶 Musique vivante</h4>
                        <p class="text-sm text-gray-600">Un mélange de styles et d'artistes pour faire découvrir, surprendre
                            et rassembler.</p>
                    </div>
                    <div class="bg-white border border-[#1d3f89]/15 rounded-xl p-6 shadow-sm">
                        <h4 class="font-bold text-[#1d3f89] mb-2">🤝 Esprit collectif</h4>
                        <p class="text-sm text-gray-600">Un événement construit avec des bénévoles, des partenaires locaux
                            et beaucoup de cœur.</p>
                    </div>
                    <div class="bg-white border border-[#1d3f89]/15 rounded-xl p-6 shadow-sm">
                        <h4 class="font-bold text-[#1d3f89] mb-2">🌾 Territoire</h4>
                        <p class="text-sm text-gray-600">Mettre en lumière Campbon et ses alentours dans une ambiance
                            chaleureuse et familiale.</p>
                    </div>
                    <div class="bg-white border border-[#1d3f89]/15 rounded-xl p-6 shadow-sm">
                        <h4 class="font-bold text-[#1d3f89] mb-2">✨ Convivialité</h4>
                        <p class="text-sm text-gray-600">Un festival à taille humaine, pensé pour bien accueillir et faire
                            passer un vrai bon moment.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="px-6 pb-4">
            <div class="container mx-auto text-center">
                <h2 class="mb-6 text-3xl font-bold text-[#1d3f89]">À bientôt à Calan'Couleurs 🌾</h2>
                <p class="max-w-3xl mx-auto text-lg text-gray-600">
                    Merci de faire partie de l'aventure. On a hâte de vous retrouver pour partager cette édition avec vous.
                </p>
            </div>
        </section>
    </div>
@endsection
