@extends('layouts.admin')

<head>
    <title>Gestion des Commandes - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">

            <!-- Statistiques rapides -->
            <div class="mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <button type="button" id="stats-toggle"
                    class="flex items-center justify-between w-full px-6 py-4 transition-colors">
                    <div class="flex items-center gap-3">
                        <i class="text-xl text-purple-600 fa-solid fa-chart-pie"></i>
                        <h3 class="text-lg font-semibold text-gray-900">Statistiques</h3>
                        <span class="hidden px-3 py-1 text-sm text-gray-500 bg-gray-100 rounded-full sm:inline-block">
                            {{ $orders->count() }} commande{{ $orders->count() > 1 ? 's' : '' }}
                        </span>
                    </div>
                    <i class="text-gray-400 transition-transform duration-300 fa-solid fa-chevron-down" id="stats-icon"></i>
                </button>

                <!-- Contenu -->
                <div id="stats-content"
                    class="overflow-hidden transition-all duration-300 border-gray-200 rounded-b-lg bg-gray-50 max-h-96"
                    style="max-height: 0;">
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                            <!-- Total des commandes -->
                            <div class="p-4 bg-white border border-gray-200 rounded-lg hover:shadow-md">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg">
                                        <i class="text-blue-600 fa-solid fa-calendar-days"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Total commandes</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $orders->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtres et recherche -->
            <div class="mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col gap-4 xl:flex-row xl:items-end">

                        <!-- Recherche -->
                        <div class="flex-1">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Rechercher</label>
                            <input type="text" id="search-input"
                                placeholder="Recherche par ID, Nom, Prénom, Email, Montant..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>

                        <!-- Statut de commande -->
                        <div class="w-full xl:w-auto xl:min-w-[180px]">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Statut commande</label>
                            <select id="status-select"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Tous</option>
                                <option value="pending">En attente</option>
                                <option value="paid">Payée</option>
                                <option value="shipped">Expédiée</option>
                                <option value="delivered">Livrée</option>
                                <option value="cancelled">Annulée</option>
                                <option value="refunded">Remboursée</option>
                            </select>
                        </div>

                        <!-- Statut du paiement -->
                        <div class="w-full xl:w-auto xl:min-w-[180px]">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Statut du paiement</label>
                            <select id="payment-status-select"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Tous</option>
                                <option value="authorized">Paiement accepté</option>
                                <option value="registered">Paiements hors ligne</option>
                            </select>
                        </div>

                        <!-- Bouton Reset -->
                        <button type="button" id="reset-filters"
                            class="flex items-center justify-center w-full px-4 py-2 text-gray-700 transition-colors bg-gray-300 rounded-md xl:w-auto hover:bg-gray-400 xl:justify-start">
                            <i class="mr-1 fa-solid fa-xmark"></i> Reset
                        </button>
                    </div>

                    <!-- Compteur de résultats -->
                    <div class="pt-4 mt-4 text-sm text-gray-600 border-t border-gray-100">
                        <span id="results-count">{{ $orders->count() }}
                            résultat{{ $orders->count() > 1 ? 's' : '' }}</span>
                    </div>
                </div>
            </div>

            <!-- Liste des commandes -->
            @if ($orders->count() > 0)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Liste des commandes
                        </h3>
                    </div>

                    <!-- Table des commandes -->
                    <div class="overflow-x-auto">
                        <table id="orders-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        ID</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Client</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Montant</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Statut commande</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Statut paiement</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-50">

                                        <!-- ID -->
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $order->id }}
                                        </td>

                                        <!-- Client -->
                                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                            {{ $order->client }}
                                        </td>

                                        <!-- Email -->
                                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                            {{ $order->email }}
                                        </td>

                                        <!-- Montant -->
                                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                            {{ $order->total_amount }} €
                                        </td>

                                        <!-- Statut commande -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{-- {{ $order->status }} --}}
                                            @if ($order->statusLabel)
                                                <span
                                                    class="items-stretch inline-flex gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-{{ $order->statusColor }}-100 text-{{ $order->statusColor }}-800">
                                                    <i class="{{ $order->statusIcon }} self-center"></i>
                                                    <span class="self-center">{{ $order->statusLabel }}</span>
                                                </span>
                                            @else
                                                <span class="italic text-gray-400">Non défini</span>
                                            @endif
                                        </td>

                                        <!-- Statut paiement -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($order->payment_statusLabel)
                                                <span
                                                    class="items-stretch inline-flex gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-{{ $order->payment_statusColor }}-100 text-{{ $order->payment_statusColor }}-800">
                                                    <i class="{{ $order->payment_statusIcon }} self-center"></i>
                                                    <span class="self-center">{{ $order->payment_statusLabel }}</span>
                                                </span>
                                            @else
                                                <span class="italic text-gray-400">Non défini</span>
                                            @endif
                                        </td>

                                        <!-- Date -->
                                        <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                            @if ($order->formatted_create_date)
                                                {{ $order->formatted_create_date }}
                                            @else
                                                <span class="italic text-gray-400">Non défini</span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="inline-flex items-stretch">
                                                <!-- Voir -->
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
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
                <div class="p-12 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center justify-center w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full">
                        <i class="text-3xl text-gray-400 fa-solid fa-microphone"></i>
                    </div>
                    <h3 class="mb-2 text-lg font-medium text-gray-900">Aucune commande trouvée</h3>
                    <p class="mb-6 text-gray-500">
                        @if (request()->anyFilled(['search']))
                            Aucune commande ne correspond à vos critères de recherche.
                        @else
                            Attendez de recevoir votre première commande via la boutique en ligne.
                        @endif
                    </p>
                    <div class="space-x-3">
                        @if (request()->anyFilled(['search']))
                            <a href="#"
                                class="inline-flex items-center px-4 py-2 text-gray-700 transition-colors bg-gray-300 rounded-md hover:bg-gray-400">
                                <i class="mr-2 fa-solid fa-xmark"></i>
                                Effacer les filtres
                            </a>
                        @endif
                        <a href="#"
                            class="inline-flex items-center px-4 py-2 text-white transition-colors bg-purple-600 rounded-md hover:bg-purple-700">
                            <i class="mr-2 fa-solid fa-user-plus"></i>
                            Ajouter une commande
                        </a>
                    </div>
                </div>
            @endif

            <div id="no-results" class="hidden p-12 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="flex items-center justify-center w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full">
                    <i class="text-3xl text-gray-400 fa-solid fa-magnifying-glass"></i>
                </div>
                <h3 class="mb-2 text-lg font-medium text-gray-900">Aucune commande ne correspond à vos critères</h3>
                <p class="mb-6 text-gray-500">
                    Essayez de modifier votre recherche ou vos filtres.
                </p>
                <button onclick="resetFilters()"
                    class="inline-flex items-center px-4 py-2 text-gray-700 transition-colors bg-gray-300 rounded-md hover:bg-gray-400">
                    <i class="mr-2 fa-solid fa-xmark"></i>
                    Effacer les filtres
                </button>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const statusSelect = document.getElementById('status-select');
            const paymentStatusSelect = document.getElementById('payment-status-select');
            const resetButton = document.getElementById('reset-filters');
            const resultsCount = document.getElementById('results-count');
            const ordersTable = document.getElementById('orders-table');
            const noResults = document.getElementById('no-results');
            const ordersContainer = ordersTable.closest('.bg-white');

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

            function filterOrders() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedStatusValue = statusSelect.value.toLowerCase();
                const selectedPaymentStatusValue = paymentStatusSelect.value.toLowerCase();

                const rows = ordersTable.querySelectorAll('tbody tr');
                let visibleCount = 0;

                rows.forEach(row => {
                    const idCell = row.querySelector('td:nth-child(1)');
                    const clientCell = row.querySelector('td:nth-child(2)');
                    const emailCell = row.querySelector('td:nth-child(3)');
                    const montantCell = row.querySelector('td:nth-child(4)');

                    const id = idCell.textContent.toLowerCase();
                    const client = clientCell.textContent.toLowerCase();
                    const email = emailCell.textContent.toLowerCase();
                    const montant = montantCell.textContent.toLowerCase();

                    const statusMap = {
                        'pending': 'en attente',
                        'paid': 'payée',
                        'shipped': 'expédiée',
                        'delivered': 'livrée',
                        'cancelled': 'annulée',
                        'refunded': 'remboursée'
                    };

                    const paymentStatusMap = {
                        'authorized': 'paiement accepté',
                        'registered': 'paiements hors ligne'
                    };

                    const matchesStatus = !selectedStatusValue || status.includes(statusMap[
                        selectedStatusValue]);
                    const matchesPaymentStatus = !selectedPaymentStatusValue || payment.includes(
                        paymentStatusMap[selectedPaymentStatusValue]);

                    const matchesSearch = !searchTerm ||
                        id.includes(searchTerm) ||
                        client.includes(searchTerm) ||
                        email.includes(searchTerm) ||
                        montant.includes(searchTerm);

                    if (matchesSearch && matchesStatus && matchesPaymentStatus) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                updateResultsCount(visibleCount);

                const hasActiveFilters = searchTerm || selectedStatusValue || selectedPaymentStatusValue;

                if (visibleCount === 0 && hasActiveFilters) {
                    // Aucun résultat avec filtres actifs -> Afficher message
                    ordersContainer.style.display = 'none';
                    noResults.classList.remove('hidden');
                } else {
                    // Des résultats ou pas de filtres -> Afficher tableau
                    ordersContainer.style.display = 'block';
                    noResults.classList.add('hidden');
                }
            }

            function updateResultsCount(count) {
                resultsCount.textContent = `${count} résultat${count !== 1 ? 's' : ''}`;
            }

            function resetFilters() {
                searchInput.value = '';
                statusSelect.value = '';
                paymentStatusSelect.value = '';
                filterOrders();
            }

            window.resetFilters = resetFilters;

            searchInput.addEventListener('input', filterOrders);
            statusSelect.addEventListener('change', filterOrders);
            paymentStatusSelect.addEventListener('change', filterOrders);
            resetButton.addEventListener('click', resetFilters);

            filterOrders();
        });
    </script>
@endsection
