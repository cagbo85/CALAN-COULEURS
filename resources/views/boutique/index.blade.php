@extends('layouts.boutique')

@section('title', 'Boutique - Calan\'Couleurs')

@section('content')
    <div class="w-full min-h-screen bg-[#EEF1FF]">

        <!-- Hero -->
        <section
            class="relative flex items-center justify-center w-full min-h-[560px] bg-center bg-cover bg-no-repeat sm:min-h-[650px]"
            style="background-image:
                linear-gradient(rgba(29,63,137,0.84), rgba(119,203,243,0.42)),
                url('/img/festival/banner.jpg');">
            <div class="px-4 text-center">
                <h1 class="mb-4 text-5xl font-bold text-white drop-shadow-lg sm:text-6xl md:text-7xl">
                    Calan'Boutique
                </h1>
                <p class="max-w-2xl mx-auto text-lg font-semibold text-white/95 drop-shadow-md sm:text-2xl">
                    La boutique officielle du festival.
                </p>
            </div>
        </section>

        <!-- Intro -->
        <section class="px-4 py-14 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="mb-10 text-center">
                    <h2 class="mb-4 text-3xl font-bold text-[#1d3f89] sm:text-4xl">
                        Notre boutique officielle
                    </h2>
                    <p class="max-w-3xl mx-auto text-lg text-gray-600">
                        Parce que l'esprit du festival ne s'arrête pas aux deux jours de juin, Calan'Boutique vous permet
                        d'emporter un peu de cette énergie avec vous, sur scène comme au quotidien.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <article class="overflow-hidden bg-white border border-[#1d3f89]/15 rounded-xl shadow-sm">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #1d3f89 0%, #77cbf3 100%);">
                            <h3 class="text-xl font-semibold text-white">L'esprit Calan'Couleurs</h3>
                        </div>
                        <div class="p-6 space-y-5 leading-relaxed text-gray-700">
                            <p>
                                Porter Calan'Boutique, c'est prolonger l'univers du festival au-delà du week-end :
                                une ambiance conviviale, locale et généreuse, portée par la musique et le collectif.
                            </p>
                            <p>
                                Chaque pièce a été pensée comme un souvenir vivant du festival, à porter au quotidien
                                et à partager avec celles et ceux qui font vivre l'aventure.
                            </p>
                        </div>
                    </article>

                    <article class="overflow-hidden bg-white border border-[#1d3f89]/15 rounded-xl shadow-sm">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #1d3f89 0%, #77cbf3 100%);">
                            <h3 class="text-xl font-semibold text-white">Une boutique qui soutient le festival</h3>
                        </div>
                        <div class="p-6 space-y-5 leading-relaxed text-gray-700">
                            <p>
                                T-shirts, pulls et accessoires vous permettent de retrouver l'identité visuelle de
                                Calan'Couleurs dans des produits pensés pour durer.
                            </p>
                            <p>
                                Chaque commande contribue directement au développement du festival et aide à faire vivre
                                un projet culturel local, indépendant et passionné.
                            </p>

                            <div class="pt-2">
                                <a href="{{ route('boutique.products') }}"
                                    class="inline-block px-4 py-2 font-semibold text-white transition-all duration-300 transform rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#1d3f89]"
                                    style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%);">
                                    Voir tous les produits <i class="fa-solid fa-arrow-right fa-xs"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Produits -->
        <section class="px-4 pb-14 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="mb-10 text-center">
                    <h2 class="mb-4 text-3xl font-bold text-[#1d3f89] sm:text-4xl">
                        Nos produits
                    </h2>
                    <p class="max-w-2xl mx-auto text-lg text-gray-600">
                        Une sélection pensée pour retrouver l'univers du festival dans des pièces à porter, offrir et
                        garder.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 mb-12 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($collections as $collection)
                        <article
                            class="overflow-hidden transition-all duration-300 transform bg-white border border-[#1d3f89]/12 rounded-xl shadow-sm hover:-translate-y-1 hover:shadow-lg">
                            <div class="aspect-square overflow-hidden bg-[#dff2fb]">
                                <img src="{{ asset($collection['image']) }}" alt="{{ $collection['title'] }}"
                                    class="object-cover w-full h-full transition-transform duration-300 hover:scale-[1.02]" />
                            </div>

                            <div class="p-6">
                                <h3 class="mb-2 text-lg font-bold text-[#1d3f89]">{{ $collection['title'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $collection['description'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="text-center">
                    <a href="{{ route('boutique.products') }}"
                        class="inline-block px-8 py-4 font-semibold text-white transition-all duration-300 transform rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#1d3f89]"
                        style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%);">
                        Explorer la boutique <i class="fa-solid fa-arrow-right fa-xs"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- Outro -->
        <section class="px-6 pb-4">
            <div class="container mx-auto text-center">
                <h2 class="mb-6 text-3xl font-bold text-[#1d3f89]">
                    Portez les couleurs du festival
                </h2>
                <p class="max-w-3xl mx-auto text-lg text-gray-600">
                    Chaque achat aide Calan'Couleurs à grandir et prolonge l'aventure bien au-delà de l'été.
                </p>
            </div>
        </section>
    </div>
@endsection
