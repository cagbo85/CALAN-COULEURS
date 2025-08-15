@extends('layouts.admin')

<head>
    <title>Gestion des Artistes - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">

            <!-- Statistiques rapides -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-microphone text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Artistes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $artistes->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Actifs</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $artistes->where('actif', 1)->count() }}</p>
                        </div>
                    </div>
                </div>

                {{-- <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar text-blue-600 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Ce weekend</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        {{ $artistes->whereBetween('begin_date', [now()->startOfWeek(), now()->endOfWeek()])->count() }}
                                    </p>
                                </div>
                            </div>
                        </div> --}}

                {{-- <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-image text-orange-600 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Avec photo</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        {{ $artistes->whereNotNull('photo')->count() }}</p>
                                </div>
                            </div>
                        </div> --}}
            </div>

            <!-- Filtres et recherche -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-4">
                        <!-- Recherche -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                            <input type="text" id="search-input" placeholder="Nom de l'artiste, style musical..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>

                        <!-- Jour -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jour</label>
                            <select id="day-select"
                                class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Tous les jours</option>
                                <option value="vendredi">Vendredi</option>
                                <option value="samedi">Samedi</option>
                                <option value="dimanche">Dimanche</option>
                            </select>
                        </div>

                        <!-- Statut -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <select id="status-select"
                                class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Tous</option>
                                <option value="1">Actif</option>
                                <option value="0">Inactif</option>
                            </select>
                        </div>

                        <!-- Bouton Reset -->
                        <div class="flex items-end">
                            <button type="button" id="reset-filters"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
                                <i class="fas fa-times mr-1"></i> Reset
                            </button>
                        </div>
                    </div>

                    <!-- Compteur de résultats -->
                    <div class="mt-4 text-sm text-gray-600">
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
                            Liste des artistes ({{ $artistes->count() }}
                            résultat{{ $artistes->count() > 1 ? 's' : '' }})
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
                                        Programmation
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Scène
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
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
                                                        <i class="fas fa-microphone text-purple-600"></i>
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

                                        <!-- Programmation -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex flex-col">
                                                <span class="font-medium capitalize">{{ $artiste->day }}</span>
                                                <span class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($artiste->begin_date)->format('H:i') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($artiste->ending_date)->format('H:i') }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Scène -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($artiste->scene)
                                                <span class="text-sm text-gray-900">
                                                    {{ $artiste->scene }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-sm">Non défini</span>
                                            @endif
                                        </td>

                                        <!-- Statut -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($artiste->actif)
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    <i class="fas fa-check mr-1"></i> Actif
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="fas fa-times mr-1"></i> Inactif
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <!-- Voir -->
                                                <a href="{{ route('admin.artistes.show', $artiste->id) }}"
                                                    class="text-blue-600 hover:text-blue-900 transition-colors"
                                                    title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <!-- Masquer -->
                                                <form method="POST"
                                                    action="{{ route('admin.artistes.destroy', $artiste->id) }}"
                                                    class="inline"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir masquer cet artiste ? Il ne sera plus visible sur le site.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-orange-600 hover:text-orange-900 transition-colors"
                                                        title="Masquer">
                                                        <i class="fas fa-eye-slash"></i>
                                                    </button>
                                                </form>
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
                        <i class="fas fa-microphone text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun artiste trouvé</h3>
                    <p class="text-gray-500 mb-6">
                        @if (request()->anyFilled(['search', 'day', 'actif']))
                            Aucun artiste ne correspond à vos critères de recherche.
                        @else
                            Commencez par ajouter votre premier artiste au festival.
                        @endif
                    </p>
                    <div class="space-x-3">
                        @if (request()->anyFilled(['search', 'day', 'actif']))
                            <a href="{{ route('admin.artistes.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                                <i class="fas fa-times mr-2"></i>
                                Effacer les filtres
                            </a>
                        @endif
                        <a href="{{ route('admin.artistes.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter un artiste
                        </a>
                    </div>
                </div>
            @endif

            <div id="no-results" class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center hidden">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun artistes ne correspond à vos critères</h3>
                <p class="text-gray-500 mb-6">
                    Essayez de modifier votre recherche ou vos filtres.
                </p>
                <button onclick="resetFilters()"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Effacer les filtres
                </button>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const daySelect = document.getElementById('day-select');
            const statusSelect = document.getElementById('status-select');
            const resetButton = document.getElementById('reset-filters');
            const resultsCount = document.getElementById('results-count');
            const artistesTable = document.getElementById('artistes-table');
            const noResults = document.getElementById('no-results');
            const artistesContainer = artistesTable.closest('.bg-white');

            function filterArtistes() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedDay = daySelect.value.toLowerCase();
                const selectedStatus = statusSelect.value;

                const rows = artistesTable.querySelectorAll('tbody tr');
                let visibleCount = 0;

                rows.forEach(row => {
                    const nameCell = row.querySelector('td:nth-child(1)');
                    const styleCell = row.querySelector('td:nth-child(2)');
                    const dayCell = row.querySelector('td:nth-child(3)');
                    const statusCell = row.querySelector('td:nth-child(5)');

                    const name = nameCell.textContent.toLowerCase();
                    const style = styleCell.textContent.toLowerCase();
                    const day = dayCell.textContent.toLowerCase();
                    const isActive = statusCell.textContent.includes('Actif') ? '1' : '0';

                    const matchesSearch = !searchTerm ||
                        name.includes(searchTerm) ||
                        style.includes(searchTerm);

                    const matchesDay = !selectedDay || day.includes(selectedDay);
                    const matchesStatus = !selectedStatus || isActive === selectedStatus;

                    if (matchesSearch && matchesDay && matchesStatus) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                updateResultsCount(visibleCount);

                const hasActiveFilters = searchTerm || selectedDay || selectedStatus;

                if (visibleCount === 0 && hasActiveFilters) {
                    // Aucun résultat avec filtres actifs → Afficher message
                    artistesContainer.style.display = 'none';
                    noResults.classList.remove('hidden');
                } else {
                    // Des résultats ou pas de filtres → Afficher tableau
                    artistesContainer.style.display = 'block';
                    noResults.classList.add('hidden');
                }
            }

            function updateResultsCount(count) {
                resultsCount.textContent = `${count} résultat${count !== 1 ? 's' : ''}`;
            }

            function resetFilters() {
                searchInput.value = '';
                daySelect.value = '';
                statusSelect.value = '';
                filterArtistes();
            }

            // ✅ RENDRE resetFilters GLOBALE
            window.resetFilters = resetFilters;

            searchInput.addEventListener('input', filterArtistes);
            daySelect.addEventListener('change', filterArtistes);
            statusSelect.addEventListener('change', filterArtistes);
            resetButton.addEventListener('click', resetFilters);

            filterArtistes();
        });
    </script>
@endsection
