@extends('layouts.app')

<head>
    <title>Accueil - CALAN-COULEURS</title>
    <link rel = "icon" type = "image/png" href="">
</head>

@section('content')
    <div class="container mx-auto px-4 py-8 flex flex-col items-center bg-blue-300">
        <h1 class="text-3xl text-red-500 font-bold underline">
            Compte à rebours place</h1>
        <p class="mt-4 text-lg italic text-center text-gray-600 dark:text-gray-400">Là</p>
        <div class="flex flex-row">
            <div class="flex flex-col items-center justify-center bg-[#8F1E98] text-white font-semibold px-5 py-2 rounded-lg mr-2">
                <span class="text-3xl">00</span>
                <span class="text-sm">Jours</span>
            </div>
            <div class="flex flex-col items-center justify-center bg-[#8F1E98] text-white font-semibold px-5 py-2 rounded-lg mr-2">
                <span class="text-3xl">00</span>
                <span class="text-sm">Heures</span>
            </div>
            <div class="flex flex-col items-center justify-center bg-[#8F1E98] text-white font-semibold px-5 py-2 rounded-lg mr-2">
                <span class="text-3xl">00</span>
                <span class="text-sm">Minutes</span>
            </div>
            <div class="flex flex-col items-center justify-center bg-[#8F1E98] text-white font-semibold px-5 py-2 rounded-lg">
                <span class="text-3xl">00</span>
                <span class="text-sm">Secondes</span>
            </div>
        </div>
        <div class="flex flex-row space-x-4 m-6">
            <!-- Bouton "Découvre la programmation" -->
            <div class="relative">
                    <a href="#" class="absolute inset-0 rounded-lg translate-x-1 translate-y-1 bg-[#8F1E98] text-[#8F1E98] px-6 py-3 font-bold uppercase tracking-wide transition duration-300">
                        Découvre la programmation →
                    </a>
                <a href="#" class="relative bg-white text-[#8F1E98] px-6 py-3 font-bold uppercase tracking-wide hover:bg-[#8F1E98] hover:text-white transition duration-300">
                    Découvre la programmation →
                </a>
            </div>

            <!-- Bouton "Acheter des billets" -->
            <div class="relative">
                <div class="absolute inset-0 bg-white rounded-lg translate-x-1 translate-y-1">
                    <a href="#" class="relative bg-white text-white px-6 py-3 font-bold uppercase tracking-wide transition duration-300">
                        Acheté des billets →
                    </a>
                </div>
                <a href="#" class="relative bg-[#8F1E98] text-white px-6 py-3 font-bold uppercase tracking-wide hover:bg-white hover:text-[#8F1E98] transition duration-300">
                    Acheter des billets →
                </a>
            </div>
        </div>

    </div>
    {{-- <div class="bg-[url(/img/logos/accueil_public.png)] h-56 w-full bg-center"></div> --}}
    {{-- <img src="{{ asset('img/logos/accueil_public.png') }}" class="inline-block w-full"
                alt="public" /> --}}

@endsection
