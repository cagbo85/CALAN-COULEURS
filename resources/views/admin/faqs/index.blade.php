@extends('layouts.admin')

<head>
    <title>Gestion des FAQS - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">

            <!-- Statistiques rapides -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-question-circle text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total FAQs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $faqs->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-eye text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Actives</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $faqs->where('actif', 1)->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-eye-slash text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Masquées</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $faqs->where('actif', 0)->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-sort-numeric-down text-orange-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Ordre max</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $faqs->max('ordre') ?? 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtres et actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-4 items-end">
                        <!-- Recherche -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                            <input type="text" id="search-input" placeholder="Question ou réponse..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>

                        <!-- Statut -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <select id="status-filter"
                                class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Tous</option>
                                <option value="1">Actives</option>
                                <option value="0">Masquées</option>
                            </select>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-2">
                            <button type="button" id="reset-filters"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
                                <i class="fas fa-times mr-1"></i> Reset
                            </button>

                            <button type="button" id="toggle-bulk-btn" onclick="toggleBulkActions()"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">
                                <i class="fas fa-tasks mr-1"></i> Actions en lot
                            </button>
                        </div>
                    </div>

                    <div id="bulk-actions" class="mt-4 p-4 bg-gray-50 rounded-lg hidden">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">
                                <span id="selected-count">0</span> FAQ(s) sélectionnée(s)
                            </span>
                            <div class="flex space-x-2">
                                <button type="button" onclick="bulkAction('activate')"
                                    class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                    <i class="fas fa-eye mr-1"></i> Activer
                                </button>
                                <button type="button" onclick="bulkAction('mask')"
                                    class="bg-orange-500 text-white px-3 py-1 rounded text-sm hover:bg-orange-600">
                                    <i class="fas fa-eye-slash mr-1"></i> Masquer
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Compteur de résultats -->
                    <div class="mt-4 text-sm text-gray-600">
                        <span id="results-count">{{ $faqs->count() }}
                            résultat{{ $faqs->count() > 1 ? 's' : '' }}</span>
                    </div>
                </div>
            </div>

            <!-- Liste des FAQs -->
            @if ($faqs->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Liste des FAQs (<span id="visible-count">{{ $faqs->count() }}</span> résultat{{ $faqs->count() > 1 ? 's' : '' }})
                        </h3>
                    </div>

                    <!-- Tableau des FAQs -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left checkbox-column" style="display: none;">
                                        <input type="checkbox" id="select-all"
                                            class="rounded border-gray-300 text-purple-600">
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                        onclick="sortTable('ordre')">
                                        <div class="flex items-center">
                                            Ordre
                                            <i class="fas fa-sort ml-1 text-gray-400"></i>
                                        </div>
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Question
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Réponse
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dernière modif
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="faqs-tbody">
                                @foreach ($faqs as $faq)
                                    <tr class="hover:bg-gray-50 faq-row" data-actif="{{ $faq->actif ? '1' : '0' }}"
                                        data-question="{{ strtolower($faq->question) }}"
                                        data-answer="{{ strtolower($faq->answer) }}" data-faq-id="{{ $faq->id }}">

                                        <td class="px-6 py-4 whitespace-nowrap checkbox-column" style="display: none;">
                                            <input type="checkbox" value="{{ $faq->id }}"
                                                class="faq-checkbox rounded border-gray-300 text-purple-600">
                                        </td>

                                        <!-- Ordre -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span
                                                    class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                                                    {{ $faq->ordre }}
                                                </span>
                                                <div class="ml-2 flex flex-col">
                                                    <button onclick="moveOrder({{ $faq->id }}, 'up')"
                                                        class="text-gray-400 hover:text-purple-600 text-xs">
                                                        <i class="fas fa-chevron-up"></i>
                                                    </button>
                                                    <button onclick="moveOrder({{ $faq->id }}, 'down')"
                                                        class="text-gray-400 hover:text-purple-600 text-xs">
                                                        <i class="fas fa-chevron-down"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Question -->
                                        <td class="px-6 py-4">
                                            <div class="max-w-xs">
                                                <p class="text-sm font-medium text-gray-900 line-clamp-2">
                                                    {{ $faq->question }}
                                                </p>
                                            </div>
                                        </td>

                                        <!-- Réponse -->
                                        <td class="px-6 py-4">
                                            <div class="max-w-md">
                                                <p class="text-sm text-gray-700 line-clamp-3">
                                                    {{ Str::limit($faq->answer, 150) }}
                                                </p>
                                            </div>
                                        </td>

                                        <!-- Statut -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($faq->actif)
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    <i class="fas fa-eye mr-1"></i> Active
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="fas fa-eye-slash mr-1"></i> Masquée
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Dernière modification -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex flex-col">
                                                <span>{{ $faq->updated_at->format('d/m/Y') }}</span>
                                                <span class="text-xs text-gray-400">
                                                    par {{ $faq->updatedBy?->firstname ?? 'Système' }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <!-- Voir/Modifier -->
                                                <a href="{{ route('admin.faqs.show', $faq->id) }}"
                                                    class="text-blue-600 hover:text-blue-900 transition-colors"
                                                    title="Voir/Modifier">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <!-- Toggle statut -->
                                                {{-- <button
                                                    onclick="toggleStatus({{ $faq->id }}, {{ $faq->actif ? 'false' : 'true' }})"
                                                    class="text-{{ $faq->actif ? 'orange' : 'green' }}-600 hover:text-{{ $faq->actif ? 'orange' : 'green' }}-900 transition-colors"
                                                    title="{{ $faq->actif ? 'Masquer' : 'Activer' }}">
                                                    <i class="fas fa-{{ $faq->actif ? 'eye-slash' : 'eye' }}"></i>
                                                </button> --}}

                                                <!-- Masquer -->
                                                <button
                                                    onclick="maskFaq({{ $faq->id }}, '{{ addslashes($faq->question) }}')"
                                                    class="text-orange-600 hover:text-orange-900 transition-colors"
                                                    title="Masquer">
                                                    <i class="fas fa-eye-slash"></i>
                                                </button>
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
                        <i class="fas fa-question-circle text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune FAQ trouvée</h3>
                    <p class="text-gray-500 mb-6">
                        Commencez par ajouter votre première question fréquente.
                    </p>
                    <a href="{{ route('admin.faqs.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter une FAQ
                    </a>
                </div>
            @endif

            <div id="no-results" class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center hidden">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune FAQ ne correspond à vos critères</h3>
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
        let bulkModeActive = false;

        function maskFaq(id, question) {
            if (confirm(
                    `Êtes-vous sûr de vouloir masquer la FAQ "${question}" ?\n\nElle ne sera plus visible sur le site.`
                )) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/faqs/${id}`;
                form.style.display = 'none';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }
        }

        function bulkAction(action) {
            const selected = Array.from(document.querySelectorAll('.faq-checkbox:checked')).map(cb => cb.value);
            if (selected.length === 0) {
                alert('Veuillez sélectionner au moins une FAQ.');
                return;
            }

            let actionText = '';
            let routeUrl = '';

            switch (action) {
                case 'activate':
                    actionText = 'activer';
                    routeUrl = '{{ route('admin.faqs.bulk-activate') }}';
                    break;
                case 'mask':
                    actionText = 'masquer';
                    routeUrl = '{{ route('admin.faqs.bulk-mask') }}';
                    break;
            }

            if (confirm(
                    `Êtes-vous sûr de vouloir ${actionText} ${selected.length} FAQ(s) ?\n\nCela modifiera leur visibilité sur le site.`
                )) {

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = routeUrl;
                form.style.display = 'none';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                selected.forEach(faqId => {
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'ids[]';
                    idInput.value = faqId;
                    form.appendChild(idInput);
                });

                document.body.appendChild(form);
                form.submit();
            }
        }

        function toggleBulkActions() {
            const bulkActions = document.getElementById('bulk-actions');
            const checkboxColumns = document.querySelectorAll('.checkbox-column');
            const toggleBtn = document.getElementById('toggle-bulk-btn');

            bulkModeActive = !bulkModeActive;

            if (bulkModeActive) {
                bulkActions.classList.remove('hidden');
                checkboxColumns.forEach(col => col.style.display = 'table-cell');
                toggleBtn.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                toggleBtn.classList.add('bg-red-500', 'hover:bg-red-600');
                toggleBtn.innerHTML = '<i class="fas fa-times mr-1"></i> Annuler sélection';
            } else {
                bulkActions.classList.add('hidden');
                checkboxColumns.forEach(col => col.style.display = 'none');
                toggleBtn.classList.remove('bg-red-500', 'hover:bg-red-600');
                toggleBtn.classList.add('bg-blue-500', 'hover:bg-blue-600');
                toggleBtn.innerHTML = '<i class="fas fa-tasks mr-1"></i> Actions en lot';

                document.querySelectorAll('.faq-checkbox, #select-all').forEach(cb => cb.checked = false);
                updateSelectedCount();
            }
        }

        function filterFaqs() {
            const search = document.getElementById('search-input').value.toLowerCase();
            const status = document.getElementById('status-filter').value;
            const rows = document.querySelectorAll('.faq-row');
            const noResults = document.getElementById('no-results');
            const faqsTable = document.querySelector(
                '.bg-white.rounded-lg.shadow-sm.border.border-gray-200:not(#no-results)');

            let visibleCount = 0;

            rows.forEach(row => {
                const question = row.dataset.question || '';
                const answer = row.dataset.answer || '';
                const actif = row.dataset.actif;

                const matchSearch = !search ||
                    question.includes(search) ||
                    answer.includes(search);

                const matchStatus = !status || actif === status;

                if (matchSearch && matchStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            updateResultsCount(visibleCount);

            if (visibleCount === 0 && (search || status)) {
                faqsTable.style.display = 'none';
                noResults.classList.remove('hidden');
            } else {
                faqsTable.style.display = 'block';
                noResults.classList.add('hidden');
            }
        }

        function updateResultsCount(count) {
            const resultsText = count + ' résultat' + (count > 1 ? 's' : '');

            const resultsCount = document.getElementById('results-count');
            if (resultsCount) {
                resultsCount.textContent = resultsText;
            }

            const visibleCount = document.getElementById('visible-count');
            if (visibleCount) {
                visibleCount.textContent = count;
            }
        }

        function resetFilters() {
            document.getElementById('search-input').value = '';
            document.getElementById('status-filter').value = '';
            filterFaqs();
        }

        document.getElementById('search-input').addEventListener('input', filterFaqs);
        document.getElementById('status-filter').addEventListener('change', filterFaqs);
        document.getElementById('reset-filters').addEventListener('click', resetFilters);

        document.getElementById('select-all').addEventListener('change', function() {
            if (bulkModeActive) {
                const checkboxes = document.querySelectorAll('.faq-checkbox');
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateSelectedCount();
            }
        });

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('faq-checkbox') && bulkModeActive) {
                updateSelectedCount();
            }
        });

        function updateSelectedCount() {
            const selected = document.querySelectorAll('.faq-checkbox:checked').length;
            document.getElementById('selected-count').textContent = selected;
        }

        function moveOrder(faqId, direction) {
            const row = document.querySelector(`tr[data-faq-id="${faqId}"]`);
            if (!row) return;

            const buttons = row.querySelectorAll('button[onclick*="moveOrder"]');
            buttons.forEach(btn => {
                btn.disabled = true;
                btn.style.opacity = '0.5';
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/faqs/${faqId}/change-order`;
            form.style.display = 'none';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            const directionInput = document.createElement('input');
            directionInput.type = 'hidden';
            directionInput.name = 'direction';
            directionInput.value = direction;
            form.appendChild(directionInput);

            document.body.appendChild(form);
            form.submit();
        }
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-4 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
