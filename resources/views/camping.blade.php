@extends('layouts.app')

@section('title', 'Camping - Calan\'Couleurs Festival ' . $currentEdition->year)

@section('content')
    <div class="w-full min-h-screen px-4 py-12 pt-8 sm:px-6 lg:px-8 bg-[#EEF1FF]">
        <div class="mx-auto mb-10 text-center max-w-7xl">
            <h1 class="text-4xl sm:text-5xl font-bold text-[#1d3f89] mb-4">
                Venir au festival Calan'Couleurs {{ $currentEdition->year }}
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-gray-600">
                Toutes les infos pratiques pour rejoindre le site facilement, stationner sereinement
                et profiter du festival les {{ $currentEdition->formatted_dates_2 }} à Campbon.
            </p>
        </div>

        <div class="grid gap-8 mx-auto mb-10 max-w-7xl md:grid-cols-2">
            <div class="overflow-hidden bg-white border border-[#1d3f89]/15 shadow-sm rounded-xl">
                <div class="px-6 py-4" style="background: linear-gradient(135deg, #1d3f89 0%, #77cbf3 100%);">
                    <h2 class="text-xl font-semibold text-white">Comment venir ?</h2>
                </div>

                <div class="p-6">
                    <p class="mb-5 text-gray-700">
                        Le festival se situe sur la route de Savenay à Plessé, au niveau des éoliennes.
                    </p>

                    <h3 class="text-lg font-bold text-[#1d3f89] mb-3">Temps de trajet depuis</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-700">
                            <span class="w-2 h-2 bg-[#1d3f89] rounded-full mr-3"></span>
                            <strong>Pontchâteau</strong><span class="ml-2">: 18 min</span>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <span class="w-2 h-2 bg-[#1d3f89] rounded-full mr-3"></span>
                            <strong>Blain</strong><span class="ml-2">: 12 min</span>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <span class="w-2 h-2 bg-[#1d3f89] rounded-full mr-3"></span>
                            <strong>Saint-Nazaire</strong><span class="ml-2">: 25 min</span>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <span class="w-2 h-2 bg-[#1d3f89] rounded-full mr-3"></span>
                            <strong>Nantes</strong><span class="ml-2">: 35 min</span>
                        </li>
                    </ul>

                    <div class="mt-6 space-y-3">
                        <a href="https://www.google.com/maps?q=47.4226619,-1.9234608333333332" target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 text-white px-4 py-2 rounded-lg font-semibold transition w-full justify-center"
                            style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%)">
                            <i class="text-white fa-solid fa-location-dot"></i> Voir sur Google Maps
                        </a>

                        <a href="https://waze.com/ul?ll=47.4226619,-1.9234608333333332&navigate=yes" target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 text-white px-4 py-2 rounded-lg font-semibold transition w-full justify-center"
                            style="background: linear-gradient(135deg, #77cbf3 40%, #1d3f89 100%)">
                            <i class="fa-brands fa-waze"></i> Ouvrir dans Waze
                        </a>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden bg-white border border-[#1d3f89]/15 shadow-sm rounded-xl flex flex-col h-full">
                <div class="px-6 py-4" style="background: linear-gradient(135deg, #1d3f89 0%, #77cbf3 100%);">
                    <h2 class="text-xl font-semibold text-white">Localisation</h2>
                </div>

                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2699.458542531653!2d-1.928335908041073!3d47.422501526353706!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x480581007447782f%3A0x4b7dec1e7d56492b!2sCalan&#39;Couleurs!5e0!3m2!1sfr!2sfr!4v1780139855857!5m2!1sfr!2sfr"
                    class="w-full flex-1 min-h-[420px] md:min-h-0" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <div class="max-w-4xl mx-auto mt-2 text-gray-700">
            <h2 class="text-2xl font-bold text-[#1d3f89] mb-4">Parking & Covoiturage</h2>
            <p class="mb-4">
                Le stationnement se fait sur les zones prévues par l’organisation.
                Suivez la signalisation sur place et les indications des équipes pour vous garer facilement.
            </p>

            <p class="mb-4">
                Pensez au covoiturage : c’est plus simple, plus convivial et plus écolo.
                Propose ou cherche une place via les groupes locaux ou sur BlaBlaCar.
            </p>

            <p>
                <a href="https://www.blablacar.fr/" target="_blank" rel="noopener noreferrer"
                    class="font-semibold text-[#1d3f89] hover:text-[#8F1E98] underline">
                    Ouvrir BlaBlaCar
                </a>
            </p>
        </div>
    @endsection
