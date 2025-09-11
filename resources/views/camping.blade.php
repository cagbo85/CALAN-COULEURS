@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold text-[#8F1E98] mb-6">Comment venir à Calan'Couleurs ?</h1>

        <div class="grid md:grid-cols-2 gap-8 mb-8">
            {{-- Informations textuelles --}}
            <div>
                <p class="mb-4 text-lg">
                    Le festival se situe sur la route de Savenay à Plessé, au niveau des éoliennes 🌬️
                </p>

                <h3 class="text-xl font-bold text-[#8F1E98] mb-3">Temps de trajet</h3>
                <ul class="mb-6 space-y-2">
                    <li class="flex items-center text-gray-700">
                        <span class="w-2 h-2 bg-[#FF0F63] rounded-full mr-3"></span>
                        <strong>Pontchâteau</strong> : 18 min
                    </li>
                    <li class="flex items-center text-gray-700">
                        <span class="w-2 h-2 bg-[#FF0F63] rounded-full mr-3"></span>
                        <strong>Blain</strong> : 12 min
                    </li>
                    <li class="flex items-center text-gray-700">
                        <span class="w-2 h-2 bg-[#FF0F63] rounded-full mr-3"></span>
                        <strong>Saint-Nazaire</strong> : 25 min
                    </li>
                    <li class="flex items-center text-gray-700">
                        <span class="w-2 h-2 bg-[#FF0F63] rounded-full mr-3"></span>
                        <strong>Nantes</strong> : 35 min
                    </li>
                </ul>

                <div class="space-y-3">
                    <a href="https://www.google.com/maps?q=47.4226619,-1.9234608333333332" target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 bg-[#8F1E98] text-white px-4 py-2 rounded-lg font-semibold hover:bg-[#FF0F63] transition w-full justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 2a6 6 0 016 6c0 4.418-6 10-6 10S4 12.418 4 8a6 6 0 016-6zm0 8a2 2 0 100-4 2 2 0 000 4z" />
                        </svg>
                        Voir sur Google Maps
                    </a>
                    <a href="https://waze.com/ul?ll=47.4226619,-1.9234608333333332&navigate=yes" target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition w-full justify-center">
                        <svg class="w-5 h-5" viewBox="0 0 48 48" fill="none">
                            <circle cx="24" cy="24" r="24" fill="#fff" />
                            <path
                                d="M36.5 32.5c1.5-2.5 2.5-5.5 2.5-8.5 0-7-6.5-12.5-15-12.5S9 17 9 24c0 3.5 1.5 6.5 4 8.5l-1 2.5a2 2 0 003 2.2l2.2-1.1c1.5.5 3.2.9 5.1.9s3.6-.3 5.1-.9l2.2 1.1a2 2 0 003-2.2l-1-2.5zm-15-3a2 2 0 114 0 2 2 0 01-4 0zm10 0a2 2 0 114 0 2 2 0 01-4 0zm-10.5 4.5a1 1 0 011.4-.4c1.2.7 2.7 1.1 4.1 1.1s2.9-.4 4.1-1.1a1 1 0 111 1.8c-1.5.9-3.3 1.3-5.1 1.3s-3.6-.4-5.1-1.3a1 1 0 01-.4-1.4z"
                                fill="#33CCFF" />
                            <ellipse cx="19.5" cy="29.5" rx="1.5" ry="1.5" fill="#222" />
                            <ellipse cx="29.5" cy="29.5" rx="1.5" ry="1.5" fill="#222" />
                        </svg> Ouvrir dans Waze
                    </a>
                </div>
            </div>

            {{-- Carte Google Maps statique --}}
            <div>
                <h3 class="text-xl font-bold text-[#8F1E98] mb-3">Localisation</h3>
                <a href="https://www.google.com/maps?q=47.4226619,-1.9234608333333332" target="_blank"
                    rel="noopener noreferrer"
                    class="block rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow"
                    aria-label="Voir l'emplacement du festival sur Google Maps (nouvelle fenêtre)">
                    <img src="https://maps.googleapis.com/maps/api/staticmap?center=47.4226619,-1.9234608333333332&zoom=13&size=400x300&maptype=roadmap&markers=color:red%7Clabel:F%7C47.4226619,-1.9234608333333332&key=AIzaSyDtXbhuoRThGexScGocdZh370bE8Xtcou0"
                        alt="Carte montrant l'emplacement du festival Calan'Couleurs"
                        class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300" loading="lazy" />
                    <div class="bg-white p-3 text-center">
                        <span class="text-[#8F1E98] font-semibold">📍 Cliquez pour ouvrir dans Google Maps</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- Message covoiturage --}}
        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
            <strong class="block text-green-700 mb-2">🚗 Pensez au covoiturage !</strong>
            <span class="text-gray-700">Plus sympa, plus écologique et plus pratique. N'hésitez pas à proposer ou chercher
                une place sur les groupes locaux ou via <a href="https://www.blablacar.fr/" target="_blank"
                    rel="noopener noreferrer" class="underline text-green-700 hover:text-green-900">BlaBlaCar</a> !</span>
        </div>
    </div>
@endsection
