@extends('layouts.boutique')

@section('title', 'Boutique - Calan\'Couleurs')

@section('content')
    <!-- Section Hero sans titre -->
    <section class="w-full h-[600px] bg-cover bg-center bg-no-repeat"
        style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('/img/festival/banner.jpg')">
    </section>

    <!-- Section Calan'boutique -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="container mx-auto max-w-4xl">
            <div class="text-center mb-12">
                <h1 class="text-4xl sm:text-5xl font-bold text-[#8F1E98] mb-6">
                    Calan'boutique
                </h1>
                <div class="w-24 h-1 mx-auto mb-8" style="background: linear-gradient(to right, #FF0F63, #8F1E98)"></div>
            </div>

            <div class="p-8 sm:p-12 rounded-2xl shadow-lg"
                style="background: linear-gradient(to bottom right, rgb(250, 245, 255), rgb(253, 242, 248))">
                <div class="space-y-6 text-center">
                    <p class="text-lg sm:text-xl leading-relaxed text-gray-700">
                        Parce que l'esprit du festival ne s'arrête pas aux deux jours de septembre, nous avons créé
                        <span class="font-bold text-[#8F1E98]">Calan'boutique</span> pour vous permettre de garder
                        un morceau de cette magie avec vous.
                    </p>

                    <p class="text-lg sm:text-xl leading-relaxed text-gray-700">
                        Découvrez notre sélection de produits exclusifs : t-shirts, sweats et accessoires
                        qui célèbrent la musique, les couleurs et l'esprit festif qui nous animent. Chaque achat
                        soutient directement le festival et la scène artistique locale.
                    </p>
                </div>

                {{-- <div class="flex justify-center items-center space-x-2 mt-8">
                        <span class="text-2xl">🎵</span>
                        <span class="text-lg font-medium text-[#8F1E98]">Portez les couleurs, vivez la musique</span>
                        <span class="text-2xl">🌈</span>
                    </div> --}}
            </div>
        </div>
        </div>
    </section>

    <!-- Section Nos produits -->
    <section class="py-16 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(to bottom, rgb(249, 250, 251), white)">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-[#8F1E98] mb-4">
                    Nos produits
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Une collection unique pensée pour les amoureux de musique et de festivals
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach ($collections as $collection)
                    <div
                        class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="h-64 flex items-center justify-center bg-gray-100">
                            <img src="{{ asset($collection['image']) }}" alt="{{ $collection['title'] }}"
                                class="object-contain h-48">
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-lg mb-2">{{ $collection['title'] }}</h3>
                            <p class="text-gray-600 text-sm">{{ $collection['description'] }}</p>
                            {{-- <a href="{{ route('boutique.products', ['category' => $collection['badge']]) }}"
                                class="inline-block mt-2 px-6 py-2 rounded-full bg-[#8F1E98] text-white font-semibold shadow hover:bg-[#FF0F63] transition">
                                Voir la collection
                            </a> --}}
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Bouton CTA -->
            <div class="text-center">
                <a href="{{ route('boutique.products') }}"
                    class="inline-flex items-center px-8 py-4 text-white font-bold text-lg rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 group"
                    style="background: linear-gradient(to right, #FF0F63, #8F1E98)">
                    <span>Voir nos produits</span>
                    <svg class="ml-3 w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- <!-- Section Call-to-action finale -->
    <section class="py-16 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(to right, #FF0F63, #8F1E98)">
        <div class="container mx-auto max-w-4xl text-center">
            <h3 class="text-3xl sm:text-4xl font-bold text-white mb-6">
                Rejoignez l'aventure Calan'Couleurs
            </h3>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                Chaque produit acheté contribue au développement du festival et soutient la scène musicale locale
            </p>
            <div class="flex justify-center items-center space-x-4 text-white">
                <span class="text-2xl">🎪</span>
                <span class="text-lg font-medium">12 & 13 septembre 2025</span>
                <span class="text-2xl">🎵</span>
            </div>
        </div>
    </section> --}}
@endsection
