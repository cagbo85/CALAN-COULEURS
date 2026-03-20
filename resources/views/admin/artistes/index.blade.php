@extends('layouts.admin')

<head>
    <title>Gestion des Artistes - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">

            <!-- Statistiques rapides -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <button type="button" id="stats-toggle"
                    class="w-full px-6 py-4 flex items-center justify-between transition-colors">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-chart-pie text-purple-600 text-xl"></i>
                        <h3 class="text-lg font-semibold text-gray-900">Statistiques</h3>
                        <span class="hidden sm:inline-block text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            {{ $artistes->count() }} artiste{{ $artistes->count() > 1 ? 's' : '' }}
                        </span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-300" id="stats-icon"></i>
                </button>

                <!-- Contenu -->
                <div id="stats-content"
                    class="border-gray-200 bg-gray-50 max-h-96 rounded-b-lg overflow-hidden transition-all duration-300"
                    style="max-height: 0;">
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                            <!-- Total des artistes -->
                            <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-calendar-days text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Total artistes</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $artistes->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtres et recherche -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col xl:flex-row xl:items-end gap-4">

                        <!-- Recherche -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                            <input type="text" id="search-input" placeholder="Nom de l'artiste, style musical..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>

                        <!-- Bouton Reset -->
                        <button type="button" id="reset-filters"
                            class="w-full xl:w-auto bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors flex items-center justify-center xl:justify-start">
                            <i class="fa-solid fa-xmark mr-1"></i> Reset
                        </button>
                    </div>

                    <!-- Compteur de résultats -->
                    <div class="text-sm text-gray-600 pt-4 mt-4 border-t border-gray-100">
                        <span id="results-count">{{ $artistes->count() }}
                            résultat{{ $artistes->count() > 1 ? 's' : '' }}</span>
                    </div>
                </div>
            </div>

            <!-- Liste des artistes -->
            @if ($artistes->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Liste des artistes
                        </h3>
                    </div>

                    <!-- Table des artistes -->
                    <div class="overflow-x-auto">
                        <table id="artistes-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Artiste
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Style
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($artistes as $artiste)
                                    <tr class="hover:bg-gray-50">
                                        <!-- Artiste -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if ($artiste->photo)
                                                    <img src="{{ asset($artiste->photo) }}" alt="{{ $artiste->name }}"
                                                        class="h-12 w-12 rounded-full object-cover mr-4">
                                                @else
                                                    <div
                                                        class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                                        <i class="fa-solid fa-microphone text-purple-600"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $artiste->name }}
                                                    </div>
                                                    @if ($artiste->description)
                                                        <div class="text-sm text-gray-500">
                                                            {{ Str::limit($artiste->description, 50) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Style -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($artiste->style)
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $artiste->style }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-sm">Non défini</span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-left">
                                            <div class="flex items-center space-x-2">
                                                <!-- Voir -->
                                                <a href="{{ route('admin.artistes.show', $artiste->id) }}"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors"
                                                    title="Voir">
                                                    <i class="fa-solid fa-eye"></i>
                                                    Voir
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- État vide -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-microphone text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun artiste trouvé</h3>
                    <p class="text-gray-500 mb-6">
                        @if (request()->anyFilled(['search']))
                            Aucun artiste ne correspond à vos critères de recherche.
                        @else
                            Commencez par ajouter votre premier artiste au festival.
                        @endif
                    </p>
                    <div class="space-x-3">
                        @if (request()->anyFilled(['search']))
                            <a href="{{ route('admin.artistes.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                                <i class="fa-solid fa-xmark mr-2"></i>
                                Effacer les filtres
                            </a>
                        @endif
                        <a href="{{ route('admin.artistes.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                            <i class="fa-solid fa-user-plus mr-2"></i>
                            Ajouter un artiste
                        </a>
                    </div>
                </div>
            @endif

            <div id="no-results" class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center hidden">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun artistes ne correspond à vos critères</h3>
                <p class="text-gray-500 mb-6">
                    Essayez de modifier votre recherche ou vos filtres.
                </p>
                <button onclick="resetFilters()"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                    <i class="fa-solid fa-xmark mr-2"></i>
                    Effacer les filtres
                </button>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const resetButton = document.getElementById('reset-filters');
            const resultsCount = document.getElementById('results-count');
            const artistesTable = document.getElementById('artistes-table');
            const noResults = document.getElementById('no-results');
            const artistesContainer = artistesTable.closest('.bg-white');

            const statsToggle = document.getElementById('stats-toggle');
            const statsContent = document.getElementById('stats-content');
            const statsIcon = document.getElementById('stats-icon');
            let isOpen = false;

            statsToggle.addEventListener('click', () => {
                isOpen = !isOpen;
                if (isOpen) {
                    statsContent.style.maxHeight = statsContent.scrollHeight + 'px';
                    statsIcon.style.transform = 'rotate(180deg)';
                } else {
                    statsContent.style.maxHeight = '0';
                    statsIcon.style.transform = 'rotate(0deg)';
                }
            });

            function filterArtistes() {
                const searchTerm = searchInput.value.toLowerCase();

                const rows = artistesTable.querySelectorAll('tbody tr');
                let visibleCount = 0;

                rows.forEach(row => {
                    const nameCell = row.querySelector('td:nth-child(1)');
                    const styleCell = row.querySelector('td:nth-child(2)');

                    const name = nameCell.textContent.toLowerCase();
                    const style = styleCell.textContent.toLowerCase();

                    const matchesSearch = !searchTerm ||
                        name.includes(searchTerm) ||
                        style.includes(searchTerm);

                    if (matchesSearch) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                updateResultsCount(visibleCount);

                const hasActiveFilters = searchTerm;

                if (visibleCount === 0 && hasActiveFilters) {
                    // Aucun résultat avec filtres actifs -> Afficher message
                    artistesContainer.style.display = 'none';
                    noResults.classList.remove('hidden');
                } else {
                    // Des résultats ou pas de filtres -> Afficher tableau
                    artistesContainer.style.display = 'block';
                    noResults.classList.add('hidden');
                }
            }

            function updateResultsCount(count) {
                resultsCount.textContent = `${count} résultat${count !== 1 ? 's' : ''}`;
            }

            function resetFilters() {
                searchInput.value = '';
                filterArtistes();
            }

            window.resetFilters = resetFilters;

            searchInput.addEventListener('input', filterArtistes);
            resetButton.addEventListener('click', resetFilters);

            filterArtistes();
        });
    </script>
@endsection
