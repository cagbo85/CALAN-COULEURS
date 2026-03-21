@extends('layouts.admin')

<head>
    <title>Gestion des utilisateurs - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">

            <!-- Statistiques rapides -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Utilisateurs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->count() }}</p>
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
                                {{ $users->where('actif', 1)->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-slash text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Désactivés</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $users->where('actif', 0)->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-shield text-orange-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Admins</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $users->whereIn('role', ['super-admin', 'admin'])->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->user()->role === 'super-admin')
                @php
                    $pendingRequests = $users
                        ->where('reactivation_requested_at', '!=', null)
                        ->where('reactivation_approved_at', null)
                        ->where('actif', false);
                @endphp

                @if ($pendingRequests->count() > 0)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                            <h3 class="text-lg font-semibold text-yellow-800">
                                Demandes de réactivation en attente ({{ $pendingRequests->count() }})
                            </h3>
                        </div>
                        <div class="mt-2">
                            @foreach ($pendingRequests as $request)
                                <div class="flex items-center justify-between bg-white p-3 rounded border mt-2">
                                    <div>
                                        <strong>{{ $request->firstname }} {{ $request->lastname }}</strong>
                                        <span class="text-gray-600">({{ $request->email }})</span>
                                        <br>
                                        <small class="text-gray-500">
                                            Demandé le {{ $request->reactivation_requested_at->format('d/m/Y à H:i') }}
                                            par {{ $request->reactivationRequestedBy->firstname ?? 'Utilisateur supprimé' }}
                                        </small>
                                    </div>
                                    <form method="POST"
                                        action="{{ route('admin.users.approve-reactivation', $request->id) }}"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
                                            Approuver
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            <!-- Filtres et recherche -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-4">
                        <!-- Recherche -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                            <input type="text" id="search-input" placeholder="Nom, prénom, email, login..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>

                        <!-- Rôle -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                            <select id="role-select"
                                class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Tous les rôles</option>
                                <option value="admin">Admins</option>
                                <option value="editor">Éditeurs</option>
                            </select>
                        </div>

                        <!-- Statut -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <select id="status-select"
                                class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Tous</option>
                                <option value="1">Actif</option>
                                <option value="0">Désactivé</option>
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
                        <span id="results-count">{{ $users->count() }}
                            résultat{{ $users->count() > 1 ? 's' : '' }}</span>
                    </div>
                </div>
            </div>

            <!-- Liste des utilisateurs -->
            @if ($users->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Liste des utilisateurs ({{ $users->count() }}
                            résultat{{ $users->count() > 1 ? 's' : '' }})
                        </h3>
                    </div>

                    <!-- Table des utilisateurs -->
                    <div class="overflow-x-auto">
                        <table id="users-table" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Utilisateur
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Contact
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rôle
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
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <!-- Utilisateur -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                                    <span class="text-purple-600 font-bold text-lg">
                                                        {{ strtoupper(substr($user->firstname, 0, 1)) }}{{ strtoupper(substr($user->lastname, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $user->firstname }} {{ $user->lastname }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        &#64;{{ $user->login }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Contact -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                            @if ($user->email_verified_at)
                                                <div class="text-xs text-green-600">
                                                    <i class="fas fa-check-circle mr-1"></i>Email vérifié
                                                </div>
                                            @else
                                                <div class="text-xs text-red-600">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>Email non vérifié
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Rôle -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($user->role === 'super-admin')
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="fas fa-crown mr-1"></i> Super Admin
                                                </span>
                                            @elseif($user->role === 'admin')
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                                    <i class="fas fa-user-shield mr-1"></i> Admin
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    <i class="fas fa-user-edit mr-1"></i> Editor
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Statut -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($user->actif)
                                                @if ($user->password && $user->email_verified_at)
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        <i class="fas fa-check mr-1"></i> Actif
                                                    </span>
                                                @elseif ($user->password && !$user->email_verified_at)
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        <i class="fas fa-envelope mr-1"></i> Email à vérifier
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                                        <i class="fas fa-key mr-1"></i> Initialisation requise
                                                    </span>
                                                @endif
                                            @else
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    <i class="fas fa-times mr-1"></i> Désactivé
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                @php
                                                    $current = auth()->user();
                                                @endphp

                                                @if ($user->actif && $current->id !== $user->id)
                                                    {{-- Bouton désactiver pour compte actif --}}
                                                    @php
                                                        $canDisable = false;
                                                        if ($current->role === 'super-admin') {
                                                            $canDisable = true;
                                                        } elseif (
                                                            $current->role === 'admin' &&
                                                            $user->role === 'editor'
                                                        ) {
                                                            $canDisable = true;
                                                        }
                                                    @endphp
                                                    @if ($canDisable)
                                                        <form method="POST"
                                                            action="{{ route('admin.users.disable', $user->id) }}"
                                                            class="inline"
                                                            onsubmit="return confirm('Êtes-vous sûr de vouloir désactiver cet utilisateur ?');">
                                                            @csrf
                                                            <button type="submit"
                                                                class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition-colors"
                                                                title="Désactiver">
                                                                Désactiver
                                                            </button>
                                                        </form>
                                                    @endif
                                                @elseif(!$user->actif && $current->id !== $user->id)
                                                    @if ($current->role === 'super-admin')
                                                        {{-- Super-admin peut réactiver directement --}}
                                                        <form method="POST"
                                                            action="{{ route('admin.users.reactivate', $user->id) }}"
                                                            class="inline"
                                                            onsubmit="return confirm('Êtes-vous sûr de vouloir réactiver cet utilisateur ?');">
                                                            @csrf
                                                            <button type="submit"
                                                                class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition-colors"
                                                                title="Réactiver">
                                                                Réactiver
                                                            </button>
                                                        </form>

                                                        {{-- Si une demande est en attente, bouton d'approbation --}}
                                                        @if ($user->reactivation_requested_at && !$user->reactivation_approved_at)
                                                            <form method="POST"
                                                                action="{{ route('admin.users.approve-reactivation', $user->id) }}"
                                                                class="inline"
                                                                onsubmit="return confirm('Approuver la demande de réactivation ?');">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition-colors"
                                                                    title="Approuver la demande">
                                                                    Approuver
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @elseif($current->role === 'admin' && $user->role === 'editor')
                                                        {{-- Admin peut demander la réactivation d'un editor --}}
                                                        @if (!$user->reactivation_requested_at)
                                                            <form method="POST"
                                                                action="{{ route('admin.users.request-reactivation', $user->id) }}"
                                                                class="inline"
                                                                onsubmit="return confirm('Demander la réactivation de cet utilisateur ?');">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="bg-orange-600 text-white px-3 py-1 rounded text-sm hover:bg-orange-700 transition-colors"
                                                                    title="Demander la réactivation">
                                                                    Demander réactivation
                                                                </button>
                                                            </form>
                                                        @else
                                                            <span class="text-orange-600 text-sm italic">
                                                                Demande en cours...
                                                            </span>
                                                        @endif
                                                    @endif
                                                @endif
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
                        <i class="fas fa-users text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun utilisateur trouvé</h3>
                    <p class="text-gray-500 mb-6">
                        @if (request()->anyFilled(['search', 'role', 'actif']))
                            Aucun utilisateur ne correspond à vos critères de recherche.
                        @else
                            La liste des utilisateurs semble vide.
                        @endif
                    </p>
                    @if (request()->anyFilled(['search', 'role', 'actif']))
                        <button onclick="resetFilters()"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Effacer les filtres
                        </button>
                    @endif
                </div>
            @endif

            <div id="no-results" class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center hidden">
                <div class="w-24 h-24 bg-gray-100 rounded-round flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun utilisateur ne correspond à vos critères</h3>
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
            const roleSelect = document.getElementById('role-select');
            const statusSelect = document.getElementById('status-select');
            const resetButton = document.getElementById('reset-filters');
            const resultsCount = document.getElementById('results-count');
            const usersTable = document.getElementById('users-table');
            const noResults = document.getElementById('no-results');
            const usersContainer = usersTable.closest('.bg-white');

            function filterUsers() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedRole = roleSelect.value.toLowerCase();
                const selectedStatus = statusSelect.value;

                const rows = usersTable.querySelectorAll('tbody tr');
                let visibleCount = 0;

                rows.forEach(row => {
                    const userCell = row.querySelector('td:nth-child(1)');
                    const contactCell = row.querySelector('td:nth-child(2)');
                    const roleCell = row.querySelector('td:nth-child(3)');
                    const statusCell = row.querySelector('td:nth-child(4)');

                    const userName = userCell.textContent.toLowerCase();
                    const userEmail = contactCell.textContent.toLowerCase();
                    const userRole = roleCell.textContent.toLowerCase();
                    const isActive = statusCell.textContent.includes('Actif') ? '1' : '0';

                    const matchesSearch = !searchTerm ||
                        userName.includes(searchTerm) ||
                        userEmail.includes(searchTerm);

                    const matchesRole = !selectedRole || userRole.includes(selectedRole);
                    const matchesStatus = !selectedStatus || isActive === selectedStatus;

                    if (matchesSearch && matchesRole && matchesStatus) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                updateResultsCount(visibleCount);

                const hasActiveFilters = searchTerm || selectedRole || selectedStatus;

                if (visibleCount === 0 && hasActiveFilters) {
                    usersContainer.style.display = 'none';
                    noResults.classList.remove('hidden');
                } else {
                    usersContainer.style.display = 'block';
                    noResults.classList.add('hidden');
                }
            }

            function updateResultsCount(count) {
                resultsCount.textContent = `${count} résultat${count !== 1 ? 's' : ''}`;
            }

            function resetFilters() {
                searchInput.value = '';
                roleSelect.value = '';
                statusSelect.value = '';
                filterUsers();
            }

            window.resetFilters = resetFilters;

            searchInput.addEventListener('input', filterUsers);
            roleSelect.addEventListener('change', filterUsers);
            statusSelect.addEventListener('change', filterUsers);
            resetButton.addEventListener('click', resetFilters);

            filterUsers();
        });
    </script>
@endsection
