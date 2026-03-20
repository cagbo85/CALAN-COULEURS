@extends('layouts.app')

@section('title', 'Programmation - Calan\'Couleurs Festival ' . $currentEdition->year)

@section('content')
    <div class="w-full pt-8 px-4 py-12 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
        @if (($allArtistes ?? collect())->isEmpty())
            <div class="max-w-2xl mx-auto">
                <article class="bg-white/95 backdrop-blur-sm rounded-xl shadow-xl overflow-hidden border-2 border-white/50">
                    <div class="p-8 text-white" style="background: linear-gradient(to right, #FF0F63, #8F1E98);">
                        <h2 class="text-center sm:text-left text-3xl font-bold uppercase tracking-wide">
                            🎵 Ça se prépare !
                        </h2>
                    </div>

                    <div class="p-8 text-center">
                        <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                            La programmation de cette édition est actuellement en cours de finalisation.
                        </p>
                        <p class="text-base text-gray-600 mb-6">
                            Restez connectés pour découvrir les artistes et les surprises qui vous attendent ! 🎶
                        </p>

                        <div class="flex justify-center gap-2 mb-2">
                            <div class="w-2 h-2 bg-[#FF0F63] rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-[#8F1E98] rounded-full animate-bounce" style="animation-delay: 0.1s">
                            </div>
                            <div class="w-2 h-2 bg-[#272AC7] rounded-full animate-bounce" style="animation-delay: 0.2s">
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        @else
            <!-- En-tête -->
            <div class="max-w-7xl mx-auto mb-12">
                <div class="text-center mb-8">
                    <h1 class="text-4xl sm:text-5xl font-bold text-[#8F1E98] mb-4">
                        Programmation {{ $currentEdition->year }}
                    </h1>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Découvrez tous les artistes du festival Calan'Couleurs les {{ $currentEdition->formatted_dates_2 }}
                        à
                        Campbon
                    </p>
                </div>

                <!-- Statistiques -->
                <div class="flex flex-wrap justify-center gap-4 mb-8">
                    <div class="bg-white rounded-lg px-6 py-3 shadow-sm border border-gray-200">
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl font-bold text-[#8F1E98]">{{ $stats['total_artistes'] }}</span>
                            <span class="text-gray-600">artistes</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg px-6 py-3 shadow-sm border border-gray-200">
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl font-bold text-[#FF0F63]">{{ $stats['total_jours'] }}</span>
                            <span class="text-gray-600">jours</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg px-6 py-3 shadow-sm border border-gray-200">
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl font-bold text-[#272AC7]">{{ $stats['scenes']->count() }}</span>
                            <span class="text-gray-600">scènes</span>
                        </div>
                    </div>
                </div>

                <!-- Navigation par onglets -->
                <div class="border-b border-gray-200 mb-8" style="position: relative; z-index: 5;">
                    <nav class="flex flex-wrap justify-center space-x-1 sm:space-x-8" role="tablist">
                        <button
                            class="tab-button tab-active px-4 py-3 text-sm font-medium border-b-2 border-[#FF0F63] text-[#FF0F63] hover:text-[#8F1E98] hover:border-gray-300"
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
            <div class="max-w-7xl mx-auto">

                <!-- Onglet "Tous les artistes" -->
                <div id="tab-all" class="tab-content" role="tabpanel">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Tous les artistes A-Z</h2>
                        <p class="text-gray-600 mb-6">Découvrez l'ensemble de la programmation du festival</p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                        @foreach ($allArtistes as $artiste)
                            @include('partials.artistes.artiste-card-simple', ['artiste' => $artiste])
                        @endforeach
                    </div>
                </div>

                <!-- Onglets par jour avec timeline chronologique -->
                @foreach ($programmation as $dayKey => $dayData)
                    <div id="tab-{{ $dayKey }}" class="tab-content hidden" role="tabpanel">
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ ucfirst($dayData['label']) }}</h2>
                            <p class="text-gray-600">
                                Programme complet de la journée
                            </p>
                        </div>

                        <!-- Timeline par périodes -->
                        <div class="relative border-l-2 border-gray-200 ml-4 sm:mx-auto max-w-5xl">
                            @foreach ($dayData['periods'] as $periodKey => $periodData)
                                <div class="mb-12">
                                    <!-- En-tête de période -->
                                    <div class="flex items-center mb-6">
                                        <div class="rounded-full w-12 h-12 flex items-center justify-center shadow-lg -ml-6"
                                            style="background: linear-gradient(to right, #8F1E98, #FF0F63)">
                                            <span
                                                class="text-white font-bold text-sm">{{ $periodData['period_Icon'] }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-xl font-bold text-gray-900">
                                                {{ ucfirst(str_replace('_', ' ', $periodData['label'])) }}
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pl-8">
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
                        btn.classList.remove('tab-active', 'border-[#FF0F63]',
                            'text-[#FF0F63]');
                        btn.classList.add('border-transparent', 'text-gray-500');
                        btn.setAttribute('aria-selected', 'false');
                    });

                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Activer l'onglet cliqué
                    this.classList.add('tab-active', 'border-[#FF0F63]', 'text-[#FF0F63]');
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
