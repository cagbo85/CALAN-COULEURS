@extends('layouts.admin')

<head>
    <title>Gestion des éditions - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <button type="button" id="stats-toggle"
                    class="w-full px-6 py-4 flex items-center justify-between transition-colors">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-chart-pie text-purple-600 text-xl"></i>
                        <h3 class="text-lg font-semibold text-gray-900">Statistiques</h3>
                        <span class="hidden sm:inline-block text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            {{ $editions->count() }} édition{{ $editions->count() > 1 ? 's' : '' }}
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
                            <!-- Total des éditions -->
                            <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-calendar-days text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Total éditions</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $editions->count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- En projet -->
                            <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-pencil text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">En projet</p>
                                        <p class="text-2xl font-bold text-gray-900">
                                            {{ $editions->where('statusLabel', 'En projet')->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- À venir -->
                            <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-clock text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">À venir</p>
                                        <p class="text-2xl font-bold text-gray-900">
                                            {{ $editions->where('statusLabel', 'À venir')->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- En cours -->
                            <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-fire text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">En cours</p>
                                        <p class="text-2xl font-bold text-gray-900">
                                            {{ $editions->where('statusLabel', 'En cours')->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Terminées -->
                            <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-circle-check text-gray-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Terminées</p>
                                        <p class="text-2xl font-bold text-gray-900">
                                            {{ $editions->whereIn('statusLabel', ['Passée', 'Archivée'])->count() }}
                                        </p>
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
                            <input type="text" id="search-input" placeholder="Année, nom..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>

                        <!-- État du festival -->
                        <div class="w-full xl:w-auto xl:min-w-[180px]">
                            <label class="block text-sm font-medium text-gray-700 mb-2">État du festival</label>
                            <select id="status-select"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Tous</option>
                                <option value="draft">En projet</option>
                                <option value="upcoming">À venir</option>
                                <option value="ongoing">En cours</option>
                                <option value="past">Passée</option>
                                <option value="archived">Archivée</option>
                            </select>
                        </div>

                        <!-- Statut (Actif/Inactif) -->
                        <div class="w-full xl:w-auto xl:min-w-[180px]">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <select id="active-select"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Tous</option>
                                <option value="1">Actif</option>
                                <option value="0">Inactif</option>
                            </select>
                        </div>

                        <!-- Bouton Reset -->
                        <button type="button" id="reset-filters"
                            class="w-full xl:w-auto bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors flex items-center justify-center xl:justify-start">
                            <i class="fa-solid fa-xmark mr-1"></i> Reset
                        </button>
                    </div>

                    <!-- Compteur de résultats -->
                    <div class="text-sm text-gray-600 pt-4 mt-4 border-t border-gray-100">
                        <span id="results-count">{{ $editions->count() }}
                            résultat{{ $editions->count() > 1 ? 's' : '' }}</span>
                    </div>
                </div>
            </div>

            <!-- Liste des éditions -->
            @if ($editions->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Liste des éditions
                        </h3>
                    </div>

                    <!-- Table des éditions -->
                    <div class="overflow-x-auto">
                        <table id="editions-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Année
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nom
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Début
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fin
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        État
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actif
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($editions as $edition)
                                    <tr class="hover:bg-gray-50">

                                        <!-- Année -->
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $edition->year }}
                                        </td>

                                        <!-- Nom -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            @if ($edition->name)
                                                {{ $edition->name }}
                                            @else
                                                <span class="text-gray-400 italic">Non défini</span>
                                            @endif
                                        </td>

                                        <!-- Début -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            @if ($edition->formatted_begin_date)
                                                {{ $edition->formatted_begin_date }}
                                            @else
                                                <span class="text-gray-400 italic">Non défini</span>
                                            @endif
                                        </td>

                                        <!-- Fin -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            @if ($edition->formatted_ending_date)
                                                {{ $edition->formatted_ending_date }}
                                            @else
                                                <span class="text-gray-400 italic">Non défini</span>
                                            @endif
                                        </td>

                                        <!-- État -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($edition->statusLabel)
                                                <span
                                                    class="items-stretch inline-flex gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-{{ $edition->statusColor }}-100 text-{{ $edition->statusColor }}-800">
                                                    <i class="{{ $edition->statusIcon }} self-center"></i>
                                                    <span class="self-center">{{ $edition->statusLabel }}</span>
                                                </span>
                                            @else
                                                <span class="text-gray-400 italic">Non défini</span>
                                            @endif
                                        </td>

                                        <!-- Actif -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($edition->actif)
                                                <span
                                                    class="items-stretch inline-flex gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    <i class="fa-solid fa-check self-end"></i>
                                                    <span class="self-center">Actif</span>
                                                </span>
                                            @else
                                                <span
                                                    class="items-stretch inline-flex gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="fa-solid fa-xmark self-end"></i>
                                                    <span class="self-center">Inactif</span>
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="items-stretch inline-flex">
                                                <!-- Voir -->
                                                <a href="{{ route('admin.editions.show', $edition->id) }}"
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
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune édition trouvée</h3>
                    <p class="text-gray-500 mb-6">
                        @if (request()->anyFilled(['search', 'status', 'active']))
                            Aucune édition ne correspond à vos critères de recherche.
                        @else
                            Commencez par ajouter votre première édition au festival.
                        @endif
                    </p>
                    <div class="space-x-3">
                        @if (request()->anyFilled(['search', 'status', 'active']))
                            <a href="{{ route('admin.editions.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                                <i class="fa-solid fa-xmark mr-2"></i>
                                Effacer les filtres
                            </a>
                        @endif
                        <a href="#"
                            class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Ajouter une édition
                        </a>
                    </div>
                </div>
            @endif

            <div id="no-results" class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center hidden">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune édition ne correspond à vos critères</h3>
                <p class="text-gray-500 mb-6">
                    Essayez de modifier votre recherche ou vos filtres.
                </p>
                <button onclick="resetFilters()"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                    <i class="fa-solid fa-xmark mr-2"></i>
                    Effacer les filtres
                </button>
            </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const statusSelect = document.getElementById('status-select');
            const activeSelect = document.getElementById('active-select');
            const resetButton = document.getElementById('reset-filters');
            const resultsCount = document.getElementById('results-count');
            const editionsTable = document.getElementById('editions-table');
            const noResults = document.getElementById('no-results');
            const editionsContainer = editionsTable.closest('.bg-white');

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

            function filterEditions() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedStatusValue = statusSelect.value;
                const selectActive = activeSelect.value;

                const rows = editionsTable.querySelectorAll('tbody tr');
                let visibleCount = 0;

                rows.forEach(row => {
                    const yearCell = row.querySelector('td:nth-child(1)');
                    const nameCell = row.querySelector('td:nth-child(2)');
                    const statusCell = row.querySelector('td:nth-child(5)');
                    const activeCell = row.querySelector('td:nth-child(6)');

                    const year = yearCell.textContent.toLowerCase();
                    const name = nameCell.textContent.toLowerCase();
                    const status = statusCell.textContent.toLowerCase().trim();
                    const active = activeCell.textContent.includes('Actif') ? '1' : '0';

                    const statusMap = {
                        'draft': 'en projet',
                        'upcoming': 'à venir',
                        'ongoing': 'en cours',
                        'past': 'passée',
                        'archived': 'archivée'
                    };

                    const matchesSearch = !searchTerm ||
                        name.includes(searchTerm) ||
                        year.includes(searchTerm);

                    const matchesStatus = !selectedStatusValue || status.includes(statusMap[
                        selectedStatusValue]);

                    const matchesActive = !selectActive || active === selectActive;

                    if (matchesSearch && matchesStatus && matchesActive) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                updateResultsCount(visibleCount);

                const hasActiveFilters = searchTerm || selectedStatusValue || selectActive;

                if (visibleCount === 0 && hasActiveFilters) {
                    // Aucun résultat avec filtres actifs → Afficher message
                    editionsContainer.style.display = 'none';
                    noResults.classList.remove('hidden');
                } else {
                    // Des résultats ou pas de filtres → Afficher tableau
                    editionsContainer.style.display = 'block';
                    noResults.classList.add('hidden');
                }
            }

            function updateResultsCount(count) {
                resultsCount.textContent = `${count} résultat${count !== 1 ? 's' : ''}`;
            }

            function resetFilters() {
                searchInput.value = '';
                statusSelect.value = '';
                activeSelect.value = '';
                filterEditions();
            }

            window.resetFilters = resetFilters;

            searchInput.addEventListener('input', filterEditions);
            statusSelect.addEventListener('change', filterEditions);
            activeSelect.addEventListener('change', filterEditions);
            resetButton.addEventListener('click', resetFilters);

            filterEditions();
        });
    </script>
@endsection
