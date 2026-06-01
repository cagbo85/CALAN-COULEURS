@extends('layouts.app')

@section('title', 'Programmation - Calan\'Couleurs Festival ' . $currentEdition->year)

@section('content')
    <div class="w-full min-h-screen px-4 py-12 pt-8 sm:px-6 lg:px-8 bg-[#EEF1FF]">
        @if (($allArtistes ?? collect())->isEmpty())
            <div class="max-w-2xl mx-auto">
                <article class="overflow-hidden border-2 shadow-xl bg-white/95 backdrop-blur-sm rounded-xl border-white/50">
                    <div class="p-8 text-white" style="background: linear-gradient(135deg, #1d3f89 0%, #77cbf3 100%)">
                        <h2 class="text-3xl font-bold tracking-wide text-center uppercase sm:text-left">
                            🎵 Ça se prépare !
                        </h2>
                    </div>

                    <div class="p-8 text-center">
                        <p class="mb-4 text-lg leading-relaxed text-gray-700">
                            La programmation de cette édition est actuellement en cours de finalisation.
                        </p>
                        <p class="mb-6 text-base text-gray-600">
                            Restez connectés pour découvrir les artistes et les surprises qui vous attendent ! 🎶
                        </p>

                        <div class="flex justify-center gap-2 mb-2">
                            <div class="w-2 h-2 bg-[#1d3f89] rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-[#8F1E98] rounded-full animate-bounce" style="animation-delay: 0.1s">
                            </div>
                            <div class="w-2 h-2 bg-[#FF0F63] rounded-full animate-bounce" style="animation-delay: 0.2s">
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        @else
            <!-- En-tête -->
            <div class="mx-auto mb-12 max-w-7xl">
                <div class="mb-8 text-center">
                    <h1 class="text-4xl sm:text-5xl font-bold text-[#1d3f89] mb-4">
                        Programmation {{ $currentEdition->year }}
                    </h1>
                    <p class="max-w-3xl mx-auto text-lg text-gray-600">
                        Découvrez tous les artistes du festival Calan'Couleurs les
                        {{ $currentEdition->formatted_dates_2 }} à Campbon
                    </p>
                </div>

                <!-- Statistiques -->
                <div class="flex flex-wrap justify-center gap-4 mb-8">
                    <div class="px-6 py-3 bg-white border border-[#1d3f89]/15 rounded-lg shadow-sm">
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl text-[#8F1E98]">{{ $stats['total_artistes'] }}</span>
                            <span class="font-medium text-gray-600">artistes</span>
                        </div>
                    </div>
                    <div class="px-6 py-3 bg-white border border-[#1d3f89]/15 rounded-lg shadow-sm">
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl text-[#FF0F63]">{{ $stats['total_jours'] }}</span>
                            <span class="font-medium text-gray-600">jours</span>
                        </div>
                    </div>
                    <div class="px-6 py-3 bg-white border border-[#1d3f89]/15 rounded-lg shadow-sm">
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl text-[#1d3f89]">{{ $stats['scenes']->count() }}</span>
                            <span class="font-medium text-gray-600">scènes</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation par onglets -->
                <div class="mb-8 border-b border-gray-200" style="position: relative; z-index: 5;">
                    <nav class="flex flex-wrap justify-center space-x-1 sm:space-x-8" role="tablist">
                        <button
                            class="tab-button tab-active px-4 py-3 text-sm font-medium border-b-2 border-[#1d3f89] text-[#1d3f89] hover:text-[#8F1E98] hover:border-gray-300"
                            data-tab="all" role="tab" aria-selected="true">
                            Tous les artistes
                        </button>
                        @foreach ($programmation as $dayKey => $dayData)
                            <button
                                class="capitalize tab-button px-4 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-[#8F1E98] hover:border-gray-300"
                                data-tab="{{ $dayKey }}" role="tab" aria-selected="false">
                                {{ $dayData['label'] }}
                            </button>
                        @endforeach
                    </nav>
                </div>
            </div>

            <!-- Contenu des onglets -->
            <div class="mx-auto max-w-7xl">

                <!-- Onglet "Tous les artistes" -->
                <div id="tab-all" class="tab-content" role="tabpanel">
                    <div class="mb-8">
                        <h2 class="mb-2 text-2xl font-bold text-gray-900">Tous les artistes A-Z</h2>
                        <p class="mb-6 text-gray-600">
                            Découvrez l'ensemble de la programmation du festival
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                        @foreach ($allArtistes as $artiste)
                            @include('partials.artistes.artiste-card-simple', ['artiste' => $artiste])
                        @endforeach
                    </div>
                </div>

                <!-- Onglets par jour avec timeline chronologique -->
                @foreach ($programmation as $dayKey => $dayData)
                    <div id="tab-{{ $dayKey }}" class="hidden tab-content" role="tabpanel">
                        <div class="mb-8">
                            <h2 class="mb-2 text-2xl font-bold text-gray-900">{{ ucfirst($dayData['label']) }}</h2>
                            <p class="text-gray-600">
                                Programme complet de la journée
                            </p>
                        </div>

                        <!-- Timeline par périodes -->
                        <div class="relative max-w-5xl ml-4 border-l-2 border-gray-200 sm:mx-auto">
                            @foreach ($dayData['periods'] as $periodKey => $periodData)
                                <div class="mb-12">
                                    <!-- En-tête de période -->
                                    <div class="flex items-center mb-6">
                                        <div class="flex items-center justify-center w-12 h-12 -ml-6 rounded-full shadow-lg"
                                            style="background: linear-gradient(90deg, #1d3f89 0%, #8f1e98 100%)">
                                            <span
                                                class="text-sm font-bold text-white">{{ $periodData['period_Icon'] }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-xl font-bold text-gray-900">
                                                {{ ucfirst(str_replace('_', ' ', $periodData['label'])) }}
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-6 pl-8 sm:grid-cols-2 md:grid-cols-3">
                                        @foreach ($periodData['artistes'] as $artiste)
                                            @include('partials.artistes.artiste-card-timeline', [
                                                'artiste' => $artiste,
                                            ])
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- JavaScript pour les onglets -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');

                    // Réinitialiser tous les onglets
                    tabButtons.forEach(btn => {
                        btn.classList.remove('tab-active', 'border-[#1d3f89]',
                            'text-[#1d3f89]');
                        btn.classList.add('border-transparent', 'text-gray-500');
                        btn.setAttribute('aria-selected', 'false');
                    });

                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Activer l'onglet cliqué
                    this.classList.add('tab-active', 'border-[#1d3f89]', 'text-[#1d3f89]');
                    this.classList.remove('border-transparent', 'text-gray-500');
                    this.setAttribute('aria-selected', 'true');

                    // Afficher le contenu correspondant
                    const targetContent = document.getElementById('tab-' + targetTab);
                    if (targetContent) {
                        targetContent.classList.remove('hidden');
                    }
                });
            });
        });
    </script>

@endsection
