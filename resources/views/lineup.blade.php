{{-- filepath: resources/views/lineup.blade.php --}}

@extends('layouts.app')

@section('title', 'Programmation - Calan\'Couleurs Festival 2025')

@section('content')
    <div class="w-full pt-8 px-4 py-12 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">

        <!-- En-tête -->
        <div class="max-w-7xl mx-auto mb-12">
            <div class="text-center mb-8">
                <h1 class="text-4xl sm:text-5xl font-bold text-[#8F1E98] mb-4">
                    Programmation 2025
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Découvrez tous les artistes du festival Calan'Couleurs les 12 & 13 septembre 2025 à Campbon
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
                        <span class="text-2xl font-bold text-[#272AC7]">2</span>
                        <span class="text-gray-600">scènes</span>
                    </div>
                </div>
            </div>

            <!-- Navigation par onglets -->
            <div class="border-b border-gray-200 mb-8" style="position: relative; z-index: 5;">
                <nav class="flex flex-wrap justify-center space-x-1 sm:space-x-8" role="tablist">
                    <button
                        class="tab-button tab-active px-4 py-3 text-sm font-medium border-b-2 border-[#FF0F63] text-[#FF0F63]"
                        data-tab="all" role="tab" aria-selected="true">
                        Tous les artistes
                    </button>
                    @foreach ($programmation as $dayKey => $dayData)
                        <button
                            class="tab-button px-4 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-[#8F1E98] hover:border-gray-300"
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
                    @foreach ($allArtistes->sortBy('name') as $artiste)
                        @include('partials.artistes.artiste-card-simple', ['artiste' => $artiste])
                    @endforeach
                </div>
            </div>

            <!-- Onglets par jour avec timeline chronologique -->
            @foreach ($programmation as $dayKey => $dayData)
                <div id="tab-{{ $dayKey }}" class="tab-content hidden" role="tabpanel">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $dayData['label'] }}</h2>
                        <p class="text-gray-600">
                            @if ($dayKey === '2025-09-12')
                                Le festival démarre vendredi soir et se prolonge dans la nuit jusqu'au samedi matin
                            @elseif($dayKey === '2025-09-13')
                                Une journée complète de musique, de l'après-midi jusqu'au bout de la nuit
                            @else
                                Programme complet de la journée
                            @endif
                        </p>
                    </div>

                    <!-- Timeline par périodes - MAINTENANT TRIÉE CHRONOLOGIQUEMENT -->
                    <div class="relative border-l-2 border-gray-200 ml-4 sm:mx-auto max-w-5xl">
                        @foreach ($dayData['periods'] as $periodKey => $periodData)
                            <div class="mb-12">
                                <!-- En-tête de période -->
                                <div class="flex items-center mb-6">
                                    <div class="bg-gradient-to-r from-[#8F1E98] to-[#FF0F63] rounded-full w-12 h-12 flex items-center justify-center shadow-lg -ml-6">
                                        <span class="text-white font-bold text-sm">
                                            @php
                                                // ✅ EXTRAIRE LE LABEL DE LA PÉRIODE
                                                $periodLabel = $periodData['label'];
                                                $icons = [
                                                    'afternoon' => '☀️',
                                                    'evening' => '🌅',
                                                    'night' => '🌙',
                                                    'late_night' => '✨',
                                                    'other' => '🎵',
                                                ];
                                                echo $icons[$periodLabel] ?? '🎵';
                                            @endphp
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-xl font-bold text-gray-900">
                                            @php
                                                $labels = [
                                                    'afternoon' => 'Après-midi festif',
                                                    'evening' => ' Montée du son',
                                                    'night' => 'Cœur de nuit',
                                                    'late_night' => ' Les derniers kiffeurs',
                                                    'other' => 'Autres moments',
                                                ];
                                                echo $labels[$periodLabel] ?? 'Moment musical';
                                            @endphp
                                        </h3>
                                        <p class="text-gray-500 text-sm">{{ $periodData['time_range'] }}</p>
                                    </div>
                                </div>

                                <!-- Artistes de la période - TRIÉS PAR HEURE -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pl-8">
                                    @foreach ($periodData['artistes'] as $artiste)
                                        @include('partials.artistes.artiste-card-timeline', ['artiste' => $artiste])
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
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
                        btn.classList.remove('tab-active', 'border-[#FF0F63]', 'text-[#FF0F63]');
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
