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

        <div class="w-full max-w-xl sm:max-w-2xl mx-auto mb-6 sm:mb-10">
            <div class="backdrop-blur-md shadow-lg px-6 sm:px-10 py-8 sm:py-10 rounded-2xl border border-white/50 flex flex-col items-center justify-center text-white text-center"
                style="background: linear-gradient(180deg, rgba(255,15,99,0.3), rgba(143,30,152,0.3), rgba(39,42,199,0.3));">

                <div class="text-5xl sm:text-6xl mb-4 drop-shadow-lg">🎉</div>

                <h2 class="text-2xl sm:text-3xl font-bold mb-3 tracking-wider drop-shadow-md">
                    Merci à tous pour cette première édition réussie !
                </h2>

                <p class="text-lg sm:text-xl drop-shadow-md font-semibold mb-2">
                    La première édition du <strong>Calan’Couleurs Festival</strong> est désormais terminée.<br>
                    Merci à tous les bénévoles, partenaires et festivaliers pour cette belle aventure !
                </p>

                <p class="text-sm sm:text-base mt-2 drop-shadow-md">
                    Rendez-vous en <span class="font-bold text-[#FFEB3B]">2026</span> pour de nouvelles aventures colorées !
                </p>
            </div>
        </div>
    </section>

    {{-- Section Tombola --}}
    <section id="tombola" class="py-16 px-4 sm:px-8 text-center text-white bg-gray-200">
        <h2 class="text-3xl font-bold uppercase mb-8 text-[#FF0F63]">Grande Tombola Calan’Couleurs 🎉</h2>

        <div class="max-w-3xl mx-auto">
            <img src="{{ asset('img/events/tombola-2025.jpeg') }}" alt="Affiche Tombola Calan’Couleurs"
                class="rounded-2xl shadow-2xl border-2 border-white/20 mb-6 mx-auto w-64 sm:w-80 md:w-96 object-contain">
            <p class="text-lg mb-8 text-[#FF0F63]/90">
                Tente ta chance et soutiens le festival pour sa prochaine édition ! 🎁<br>
                Vous avez jusqu'au <strong>12/11</strong> pour participer.<br>
                Un DJ set aura lieu ainsi qu'un bar pendant la soirée.
            </p>
            <a href="https://www.helloasso.com/associations/calan-couleurs/evenements/tombola-calan-couleurs-1"
                target="_blank" rel="noopener noreferrer"
                class="inline-block mt-3 px-8 py-4 bg-[#8F1E98] text-white font-semibold rounded-xl hover:bg-[#FF0F63] transition duration-300">
                Participer à la tombola →
            </a>
        </div>
    </section>

    {{-- Section FAQ --}}
    <section aria-labelledby="faq-heading" class="">
        <div id="faq-root" aria-live="polite"></div>
    </section>
@endsection
