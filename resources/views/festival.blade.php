@extends('layouts.app')

@section('title', 'Notre histoire - Calan\'Couleurs')

@section('content')
    <!-- Section Hero avec image pleine hauteur -->
    <section class="w-full h-[700px] bg-cover bg-center bg-no-repeat flex items-center justify-center"
        style="background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('/img/festival/banner.jpg')">
        <div class="text-center px-4">
            <h1 class="text-5xl sm:text-6xl font-bold text-white drop-shadow-lg mb-4">
                Calan'Couleurs
            </h1>
            <p class="text-xl sm:text-2xl font-medium text-white drop-shadow-md">
                12 & 13 septembre 2025
            </p>
        </div>
    </section>

    <!-- Section Description -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="container mx-auto max-w-3xl">
            <div class="p-8 rounded-lg shadow-md"
                style="background: linear-gradient(180deg, rgba(255,15,99,0.2), rgba(143,30,152,0.2), rgba(39,42,199,0.2));">
                <h2 class="text-3xl font-bold text-[#8F1E98] mb-8 text-center">Notre histoire</h2>

                <div class="space-y-6">
                    <p class="text-lg font-bold leading-relaxed">
                        Nous sommes une bande de copains passionnés de musique et attachés à notre territoire. Pour
                        faire vivre la scène locale, créer du lien et partager un moment festif, nous avons lancé
                        Calan'Couleurs, un festival qui nous ressemble.
                    </p>

                    <p class="text-lg font-bold leading-relaxed">
                        Rendez-vous les 12 et 13 septembre 2025 à Campbon (44 750) pour une première édition haute
                        en couleur, avec une programmation mêlant artistes émergents et confirmés, dans une ambiance
                        conviviale et festive.
                    </p>

                    <p class="text-xl font-bold text-center text-[#FF0F63] mt-8">
                        À bientôt ! 🌾
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
