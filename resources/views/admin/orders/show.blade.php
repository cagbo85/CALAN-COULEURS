@extends('layouts.admin')

<head>
    <title>Commande #{{ $order->id ?? 'N/A' }} - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">
            <div class="mb-6 overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                <div class="relative h-48"
                    style="background: linear-gradient(135deg, rgba(147,51,234,1) 0%, rgba(236,72,153,1) 100%);">
                    <div class="absolute inset-x-0 top-0 p-3 sm:p-4">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ route('admin.orders.index') }}"
                                class="inline-flex items-center justify-center w-full px-4 py-2 text-sm text-white transition-all bg-black rounded-lg sm:w-auto sm:justify-start bg-opacity-30 hover:bg-opacity-50 sm:text-base">
                                <i class="mr-2 fa-solid fa-arrow-left"></i>
                                Retour à la liste
                            </a>

                            <div class="flex justify-end w-full gap-2 sm:w-auto">
                                <button type="button" onclick="toggleEditMode()" id="edit-btn"
                                    class="flex items-center justify-center flex-1 px-4 py-2 text-white transition-colors bg-green-600 rounded-lg sm:flex-none hover:bg-green-700">
                                    <i class="mr-2 fa-solid fa-pen-to-square"></i>
                                    Modifier
                                </button>
                                <button type="button" onclick="toggleEditMode()" id="cancel-btn" style="display: none;"
                                    class="flex items-center justify-center flex-1 px-4 py-2 text-white transition-colors bg-gray-600 rounded-lg sm:flex-none hover:bg-gray-700">
                                    <i class="mr-2 fa-solid fa-xmark"></i>
                                    Annuler
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info commande -->
                <div class="relative px-6 pb-6">
                    <div class="flex flex-col gap-6 -mt-16 sm:flex-row sm:items-end">
                        <!-- Photo commande -->
                        <div class="relative flex justify-center flex-shrink-0">
                            <div
                                class="flex items-center justify-center w-32 h-32 bg-white border-4 border-white rounded-full shadow-lg">
                                <span class="text-4xl font-bold text-black">{{ $order->id }}</span>
                            </div>

                            <!-- Badge statut -->
                            <div class="absolute -bottom-2 sm:right-0">
                                <span
                                    class="bg-{{ $order->statusColor }}-500 text-white px-3 gap-1 py-1 rounded-full text-xs font-medium flex items-center">
                                    <i class="{{ $order->statusIcon }} mr-1"></i> {{ $order->statusLabel }}
                                </span>
                            </div>
                        </div>

                        <!-- Info commande -->
                        <div class="flex-1 text-center sm:text-left">
                            <h1 class="text-3xl font-bold text-gray-900">{{ 'Commande #' . $order->id }}
                            </h1>

                            <!-- Dates rapides -->
                            <div
                                class="flex flex-col items-center mt-2 space-y-2 text-sm text-gray-600 sm:flex-row sm:items-start sm:space-y-0 sm:space-x-4">
                                <span>
                                    <i class="mr-1 fa-solid fa-calendar-days"></i>
                                    Commande passée le {{ $order->formatted_create_date }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" id="order-form"
                class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl" novalidate>
                @csrf
                @method('PUT')

                <div class="p-8 space-y-8">

                    <!-- Informations générales -->
                    <div class="space-y-6">
                        <h3 class="pb-2 text-xl font-semibold text-gray-900 border-b border-gray-200">
                            Informations générales
                        </h3>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                            <!-- ID -->
                            <div class="space-y-2">
                                <x-input-label class="text-sm font-medium text-gray-700">Numéro de commande</x-input-label>
                                <p class="text-lg font-semibold text-gray-900">#{{ $order->id }}</p>
                            </div>

                            <!-- Client -->
                            <div class="space-y-2">
                                <x-input-label class="text-sm font-medium text-gray-700">Client</x-input-label>
                                <p class="text-lg text-gray-900">{{ $order->firstname }}
                                    {{ strtoupper($order->lastname) }}</p>
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <x-input-label class="text-sm font-medium text-gray-700">Email</x-input-label>
                                <p class="text-gray-900">{{ $order->email }}</p>
                            </div>

                            <!-- Adresse -->
                            <div class="space-y-2">
                                <x-input-label class="text-sm font-medium text-gray-700">Adresse</x-input-label>
                                <p class="text-gray-900">
                                    {{ $order->adresse }}<br>
                                    {{ $order->code_postal }} {{ $order->ville }}<br>
                                    {{ $order->pays }}
                                </p>
                            </div>

                            <!-- Date -->
                            <div class="space-y-2">
                                <x-input-label class="text-sm font-medium text-gray-700">Date de création</x-input-label>
                                <p class="text-gray-900">{{ $order->formatted_create_date }}</p>
                            </div>

                        </div>
                    </div>

                    <!-- Paiement -->
                    <div class="space-y-6">
                        <h3 class="pb-2 text-xl font-semibold text-gray-900 border-b border-gray-200">
                            Paiement
                        </h3>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                            <!-- Montant -->
                            <div class="space-y-2">
                                <x-input-label class="text-sm font-medium text-gray-700">Montant total</x-input-label>
                                <p class="text-lg font-semibold text-gray-900">{{ number_format($order->total_amount, 2) }}
                                    €</p>
                            </div>

                            <!-- Statut paiement -->
                            <div class="space-y-2">
                                <x-input-label class="text-sm font-medium text-gray-700">Statut paiement</x-input-label>

                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-{{ $order->payment_statusColor }}-100 text-{{ $order->payment_statusColor }}-800">
                                    <i class="{{ $order->payment_statusIcon }} mr-1"></i>
                                    {{ $order->payment_statusLabel }}
                                </span>
                            </div>

                            <!-- HelloAsso ID -->
                            <div class="space-y-2">
                                <x-input-label class="text-sm font-medium text-gray-700">Référence HelloAsso</x-input-label>
                                <p class="text-gray-900">{{ $order->helloasso_id ?? '—' }}</p>
                            </div>

                            <!-- Payment ID -->
                            <div class="space-y-2">
                                <x-input-label class="text-sm font-medium text-gray-700">ID Paiement</x-input-label>
                                <p class="text-gray-900">{{ $order->helloasso_payment_id ?? '—' }}</p>
                            </div>

                            <!-- Date paiement -->
                            <div class="space-y-2">
                                <x-input-label class="text-sm font-medium text-gray-700">Payée le</x-input-label>
                                <p class="text-gray-900">{{ $order->formatted_paid_at ?? '—' }}</p>
                            </div>

                        </div>
                    </div>

                    <!-- Statut commande -->
                    <div class="space-y-6">
                        <h3 class="pb-2 text-xl font-semibold text-gray-900 border-b border-gray-200">
                            Statut de la commande
                        </h3>

                        <div class="space-y-2">

                            <!-- View mode -->
                            <div class="view-mode">
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-{{ $order->statusColor }}-100 text-{{ $order->statusColor }}-800">
                                    <i class="{{ $order->statusIcon }} mr-1"></i>
                                    {{ $order->statusLabel }}
                                </span>
                            </div>

                            <!-- Edit mode -->
                            <div class="edit-mode" style="display:none;">
                                <select name="status" id="status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente
                                    </option>
                                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Payée</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Expédiée
                                    </option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Livrée
                                    </option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                                        Annulée</option>
                                    <option value="refunded" {{ $order->status === 'refunded' ? 'selected' : '' }}>
                                        Remboursée</option>
                                </select>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Actions en mode édition -->
                <div class="px-8 py-6 space-y-4 border-t border-gray-200 edit-mode bg-gray-50" style="display: none;">

                    <!-- Boutons d'action -->
                    <div class="flex flex-col gap-3 lg:flex-row lg:items-center">
                        <button type="button" onclick="toggleEditMode()"
                            class="flex items-center justify-center w-full px-4 py-2 text-gray-700 transition-colors bg-gray-300 rounded-lg lg:w-auto hover:bg-gray-400 lg:justify-start">
                            <i class="mr-2 fa-solid fa-xmark"></i>
                            Annuler
                        </button>

                        <button type="submit"
                            class="flex items-center justify-center w-full px-4 py-2 font-medium text-white transition-colors bg-blue-600 rounded-lg lg:w-auto hover:bg-blue-700 lg:justify-start">
                            <i class="mr-2 fa-solid fa-floppy-disk"></i>
                            Enregistrer les modifications
                        </button>
                    </div>

                    <!-- Infos de modification -->
                    <div class="pt-4 border-t border-gray-300">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="flex-shrink-0 fa-solid fa-circle-info"></i>
                            <div class="flex flex-col sm:flex-row sm:gap-1">
                                <span>Dernière modification :</span>
                                <span class="font-medium">
                                    {{ $order->formatted_updated_at }}
                                </span>
                                @if ($order->updated_by_login)
                                    <span class="hidden sm:inline">par</span>
                                    <span class="font-medium">{{ $order->updated_by_login }}</span>
                                @else
                                    <span class="hidden sm:inline">par</span>
                                    <span class="font-medium">—</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </main>
    <script>
        function toggleEditMode() {
            const viewElements = document.querySelectorAll('.view-mode');
            const editElements = document.querySelectorAll('.edit-mode');
            const editBtn = document.getElementById('edit-btn');
            const cancelBtn = document.getElementById('cancel-btn');

            viewElements.forEach(el => {
                el.style.display = el.style.display === 'none' ? 'block' : 'none';
            });

            editElements.forEach(el => {
                el.style.display = el.style.display === 'none' ? 'block' : 'none';
            });

            editBtn.style.display = editBtn.style.display === 'none' ? 'flex' : 'none';
            cancelBtn.style.display = cancelBtn.style.display === 'none' ? 'flex' : 'none';
        }
    </script>
@endsection
