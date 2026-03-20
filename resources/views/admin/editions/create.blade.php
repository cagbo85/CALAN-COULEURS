@extends('layouts.admin')

<head>
    <title>Création d'une édition - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">
            <!-- En-tête -->
            <div class="mb-6 space-y-2">
                <a href="{{ route('admin.editions.index') }}"
                    class="bg-black bg-opacity-30 text-white px-4 py-2 rounded-lg hover:bg-opacity-50 transition-all items-center">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Créer une nouvelle édition</h1>
                <p class="text-gray-600 mt-2">Ajoutez une nouvelle édition du festival Calan'Couleurs</p>
            </div>

            <form id="edition-form" action="{{ route('admin.editions.store') }}" method="POST" enctype="multipart/form-data"
                novalidate>
                @csrf

                <div class="space-y-6">
                    <!-- Informations générales -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4"
                            style="background: linear-gradient(135deg, rgba(147,51,234,1) 0%, rgba(236,72,153,1) 100%);">
                            <h3 class="text-xl font-semibold text-white flex items-center">
                                <i class="fa-solid fa-circle-info mr-3"></i>
                                Informations générales
                            </h3>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Année -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="year" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Année : <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="">
                                    <x-text-input id="year"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                        type="number" name="year" :value="old('year', (int) date('Y') + 1)" required min="2000"
                                        max="2099" placeholder="{{ (int) date('Y') + 1 }}" autocomplete="year"
                                        autofocus />
                                    <x-input-error :messages="$errors->get('year')" class="mt-2" />
                                    <p class="mt-2 text-xs text-gray-500">
                                        <i class="fa-solid fa-lightbulb text-yellow-500 mr-1"></i>
                                        L'année de l'édition du festival
                                    </p>
                                </div>
                            </div>

                            <!-- Nom de l'édition -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="name" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Nom de l'édition :
                                </x-input-label>
                                <div class="">
                                    <x-text-input id="name"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                        type="text" name="name" :value="old('name')"
                                        placeholder="ex: Calan'Couleurs 2K{{ (int) date('y') + 1 }}" autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    <p class="mt-2 text-xs text-gray-500">
                                        <i class="fa-solid fa-circle-info text-blue-500 mr-1"></i>
                                        Optionnel - Laissez vide pour utiliser juste l'année
                                    </p>
                                </div>
                            </div>

                            <!-- Url de réservation -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="reservation_url"
                                    class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Url pour la réservation :
                                </x-input-label>
                                <div class="">
                                    <x-text-input id="reservation_url"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                        type="text" name="reservation_url" :value="old('reservation_url')"
                                        placeholder="ex: https://reservation.example.com" autocomplete="reservation_url" />
                                    <x-input-error :messages="$errors->get('reservation_url')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dates & Horaires -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4"
                            style="background: linear-gradient(135deg, rgba(147,51,234,1) 0%, rgba(236,72,153,1) 100%);">
                            <h3 class="text-xl font-semibold text-white flex items-center">
                                <i class="fa-solid fa-calendar-days mr-3"></i>
                                Dates & horaires
                            </h3>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Date de début -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="begin_date" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Début du festival : <span class="text-red-500">*</span>
                                </x-input-label>

                                <div class="">
                                    <x-text-input id="begin_date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        type="datetime-local" name="begin_date" :value="old('begin_date')" required />
                                    <x-input-error :messages="$errors->get('begin_date')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Date de fin -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="ending_date" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Fin du festival : <span class="text-red-500">*</span>
                                </x-input-label>

                                <div class="">
                                    <x-text-input id="ending_date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        type="datetime-local" name="ending_date" :value="old('ending_date')" required />
                                    <x-input-error :messages="$errors->get('ending_date')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statut & Configuration -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4"
                            style="background: linear-gradient(135deg, rgba(147,51,234,1) 0%, rgba(236,72,153,1) 100%);">
                            <h3 class="text-xl font-semibold text-white flex items-center">
                                <i class="fa-solid fa-gears mr-3"></i>
                                Statut & Configuration
                            </h3>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Statut -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="status" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    État de l'édition : <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="">
                                    <select id="status" name="status" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                        <option value="">Sélectionnez un statut...</option>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>
                                            En projet
                                        </option>
                                        <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>
                                            À venir
                                        </option>
                                        <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>
                                            En cours
                                        </option>
                                        <option value="past" {{ old('status') == 'past' ? 'selected' : '' }}>
                                            Passée
                                        </option>
                                        <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>
                                            Archivée
                                        </option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />

                                    <!-- Aide contextuelle -->
                                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                        <div class="flex gap-2">
                                            <i class="fa-solid fa-lightbulb text-blue-600 flex-shrink-0 mt-0.5"></i>
                                            <div class="text-xs text-blue-700 space-y-2">
                                                <p class="font-semibold text-sm">Les différents statuts :</p>
                                                <ul class="space-y-1.5 ml-2">
                                                    <li class="flex gap-2">
                                                        <span class="font-bold text-blue-900 min-w-15">En projet :</span>
                                                        <span>L'édition est en cours de planification. Les dates ne sont pas
                                                            encore confirmées.</span>
                                                    </li>
                                                    <li class="flex gap-2">
                                                        <span class="font-bold text-blue-900 min-w-15">À venir :</span>
                                                        <span>L'édition est confirmée. Les dates et les détails sont
                                                            finalisés.</span>
                                                    </li>
                                                    <li class="flex gap-2">
                                                        <span class="font-bold text-blue-900 min-w-15">En cours :</span>
                                                        <span>Le festival se déroule actuellement.</span>
                                                    </li>
                                                    <li class="flex gap-2">
                                                        <span class="font-bold text-blue-900 min-w-15">Passée :</span>
                                                        <span>Le festival est terminé et accessible en archives.</span>
                                                    </li>
                                                    <li class="flex gap-2">
                                                        <span class="font-bold text-blue-900 min-w-15">Archivée :</span>
                                                        <span>Très ancien festival. À utiliser pour l'historique
                                                            uniquement.</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Visibilité -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="actif" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Visibilité : <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <!-- Option Active -->
                                        <label
                                            class="relative flex items-center p-4 bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl cursor-pointer hover:shadow-md transition-all group">
                                            <input type="radio" name="actif" value="1"
                                                {{ old('actif', '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                                            <div
                                                class="absolute inset-0 border-2 border-green-500 rounded-xl opacity-0 peer-checked:opacity-100 transition-opacity">
                                            </div>
                                            <div class="flex items-start gap-3 relative z-10">
                                                <div
                                                    class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <i class="fa-solid fa-eye text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-green-900">Active</div>
                                                    <div class="text-xs text-green-700 mt-1">Visible publiquement</div>
                                                </div>
                                            </div>
                                        </label>

                                        <!-- Option Inactive -->
                                        <label
                                            class="relative flex items-center p-4 bg-gradient-to-br from-orange-50 to-red-50 border-2 border-orange-200 rounded-xl cursor-pointer hover:shadow-md transition-all group">
                                            <input type="radio" name="actif" value="0"
                                                {{ old('actif') == '0' ? 'checked' : '' }} class="sr-only peer">
                                            <div
                                                class="absolute inset-0 border-2 border-orange-500 rounded-xl opacity-0 peer-checked:opacity-100 transition-opacity">
                                            </div>
                                            <div class="flex items-start gap-3 relative z-10">
                                                <div
                                                    class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <i class="fa-solid fa-eye-slash text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-orange-900">Inactive</div>
                                                    <div class="text-xs text-orange-700 mt-1">Masquée au public</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('actif')" class="mt-2" />

                                    <!-- Aide contextuelle -->
                                    <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                        <div class="flex gap-2">
                                            <i class="fa-solid fa-eye text-amber-600 flex-shrink-0 mt-0.5"></i>
                                            <div class="text-xs text-amber-800 space-y-2">
                                                <p class="font-semibold text-sm">Comment fonctionne la visibilité ?</p>
                                                <p class="text-amber-700">
                                                    La visibilité contrôle si l'édition apparaît sur le site public
                                                    (galerie, archives, mur-souvenir, etc.).
                                                </p>

                                                <div class="bg-white rounded p-2 mt-2">
                                                    <p class="font-bold text-amber-900 mb-1.5">Règles automatiques :</p>
                                                    <ul class="space-y-1 ml-2 text-amber-800">
                                                        <li>• <strong>En projet</strong> -> Toujours masquée (inactive)</li>
                                                        <li>• <strong>À venir / En cours</strong> -> Toujours visible
                                                            (active)</li>
                                                        <li>• <strong>Passée</strong> -> Toujours visible
                                                            (active)</li>
                                                    </ul>
                                                </div>

                                                <div class="bg-white rounded p-2 mt-2">
                                                    <p class="font-bold text-amber-900 mb-1.5">Vous pouvez choisir :</p>
                                                    <ul class="space-y-1 ml-2 text-amber-800">
                                                        <li>
                                                            <strong>Archivée</strong> ->
                                                            <span class="text-green-700">Active</span> pour l'historique,
                                                            ou
                                                            <span class="text-red-700">Inactive</span> pour la cacher
                                                            complètement
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div
                        class="bg-white rounded-xl shadow-lg border border-gray-200 px-6 py-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                        <a href="{{ route('admin.editions.index') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all">
                            <i class="fa-solid fa-xmark mr-2"></i>
                            Annuler
                        </a>

                        <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg transition-colors items-center font-medium">
                            <i class="fa-solid fa-floppy-disk mr-2"></i>
                            Enregistrer l'édition
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('edition-form');
            const statusSelect = document.getElementById('status');

            // Éditions existantes
            const existingEditions = @json(\App\Models\Edition::select('status', 'name', 'year')->get());

            form.addEventListener('submit', function(e) {
                const selectedStatus = statusSelect.value;

                // Vérifier les conflits selon les nouvelles règles
                let conflictingEditions = [];
                let warningMessage = '';

                if (selectedStatus === 'upcoming') {
                    // À venir archive : upcoming, ongoing, past
                    conflictingEditions = existingEditions.filter(edition => ['upcoming', 'ongoing', 'past']
                        .includes(edition.status)
                    );
                    warningMessage =
                        'Toutes les éditions "À venir", "En cours" et "Passée" seront ARCHIVÉES.';
                } else if (selectedStatus === 'ongoing') {
                    // En cours archive : upcoming, ongoing, past
                    conflictingEditions = existingEditions.filter(edition => ['upcoming', 'ongoing', 'past']
                        .includes(edition.status)
                    );
                    warningMessage =
                        'Toutes les éditions "À venir", "En cours" et "Passée" seront ARCHIVÉES.';
                } else if (selectedStatus === 'past') {
                    // Passée archive : upcoming, ongoing (pas les autres past)
                    conflictingEditions = existingEditions.filter(edition => ['upcoming', 'ongoing']
                        .includes(edition.status)
                    );
                    warningMessage = 'Toutes les éditions "À venir" et "En cours" seront ARCHIVÉES.';
                }

                if (conflictingEditions.length > 0) {
                    e.preventDefault();

                    const statusLabels = {
                        'draft': 'En projet',
                        'upcoming': 'À venir',
                        'ongoing': 'En cours',
                        'past': 'Passée',
                        'archived': 'Archivée'
                    };

                    const newLabel = statusLabels[selectedStatus];

                    // Liste des éditions impactées
                    const editionsList = conflictingEditions.map(edition => {
                        const name = edition.name || `Édition ${edition.year}`;
                        const status = statusLabels[edition.status];
                        return `  • ${name} (${status})`;
                    }).join('\n');

                    const message = `⚠️ ATTENTION !\n\n` +
                        `Vous êtes sur le point de créer une édition "${newLabel}".\n\n` +
                        `${warningMessage}\n\n` +
                        `Éditions concernées :\n${editionsList}\n\n` +
                        `Voulez-vous vraiment continuer ?`;

                    if (confirm(message)) {
                        form.submit();
                    }
                }
            });
        });
    </script>
@endsection
