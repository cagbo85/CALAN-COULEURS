@extends('layouts.admin')

<head>
    <title>{{ $edition->name ?? 'Édition ' . $edition->year }} - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="relative h-48"
                    style="background: linear-gradient(135deg, rgba(147,51,234,1) 0%, rgba(236,72,153,1) 100%);">
                    <div class="absolute inset-x-0 top-0 p-3 sm:p-4">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ route('admin.editions.index') }}"
                                class="inline-flex w-full sm:w-auto items-center justify-center sm:justify-start bg-black bg-opacity-30 text-white px-4 py-2 rounded-lg hover:bg-opacity-50 transition-all text-sm sm:text-base">
                                <i class="fa-solid fa-arrow-left mr-2"></i>
                                Retour à la liste
                            </a>

                            <div class="flex w-full sm:w-auto gap-2 justify-end">
                                <button type="button" onclick="toggleEditMode()" id="edit-btn"
                                    class="flex-1 sm:flex-none bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center">
                                    <i class="fa-solid fa-pen-to-square mr-2"></i>
                                    Modifier
                                </button>
                                <button type="button" onclick="toggleEditMode()" id="cancel-btn" style="display: none;"
                                    class="flex-1 sm:flex-none bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center justify-center">
                                    <i class="fa-solid fa-xmark mr-2"></i>
                                    Annuler
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info édition -->
                <div class="relative px-6 pb-6">
                    <div class="flex flex-col sm:flex-row sm:items-end -mt-16 gap-6">
                        <!-- Photo édition -->
                        <div class="relative flex justify-center flex-shrink-0">
                            <div
                                class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-white flex items-center justify-center">
                                <span class="text-4xl font-bold text-black">{{ $edition->year }}</span>
                            </div>

                            <!-- Badge statut -->
                            <div class="absolute -bottom-2 sm:right-0">
                                <span
                                    class="bg-{{ $edition->statusColor }}-500 text-white px-3 gap-1 py-1 rounded-full text-xs font-medium flex items-center">
                                    <i class="{{ $edition->statusIcon }} mr-1"></i> {{ $edition->statusLabel }}
                                </span>
                            </div>
                        </div>

                        <!-- Info édition -->
                        <div class="flex-1 text-center sm:text-left">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $edition->name ?? 'Édition ' . $edition->year }}
                            </h1>

                            <!-- Dates rapides -->
                            <div
                                class="mt-2 flex flex-col sm:flex-row items-center sm:items-start text-sm text-gray-600 space-y-2 sm:space-y-0 sm:space-x-4">
                                <span>
                                    <i class="fa-solid fa-calendar-days mr-1"></i>
                                    du {{ $edition->formatted_begin_date }} au {{ $edition->formatted_ending_date }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('admin.editions.update', $edition->id) }}" method="POST" enctype="multipart/form-data"
                id="edition-form" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" novalidate>
                @csrf
                @method('PUT')

                <div class="p-8 space-y-8">

                    <!-- Informations -->
                    <div class="grid grid-cols-2 gap-8">

                        <!-- Informations générales -->
                        <div class="space-y-6 col-span-2">
                            <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">
                                Informations générales
                            </h3>

                            <!-- Année -->
                            <div class="space-y-2">
                                <x-input-label for="year" class="text-sm font-medium text-gray-700">Année <span
                                        class="text-red-500">*</span> </x-input-label>
                                <div class="view-mode">
                                    <p class="text-lg font-semibold text-gray-900">{{ $edition->year }}</p>
                                </div>
                                <div class="edit-mode" style="display: none;">
                                    <x-text-input id="year"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        type="number" name="year" value="{{ old('year', $edition->year) }}" required
                                        min="2000" max="2099" placeholder="{{ $edition->year }}"
                                        autocomplete="year" autofocus />
                                    <x-input-error :messages="$errors->get('year')" class="mt-1" />
                                </div>
                            </div>

                            <!-- Nom -->
                            <div class="space-y-2">
                                <x-input-label for="name" class="text-sm font-medium text-gray-700">Nom de
                                    l'édition</x-input-label>
                                <div class="view-mode">
                                    @if ($edition->name)
                                        <p class="text-lg text-gray-900">{{ $edition->name }}</p>
                                    @else
                                        <p class="text-gray-400 italic">Non défini</p>
                                    @endif
                                </div>
                                <div class="edit-mode" style="display: none;">
                                    <x-text-input id="name"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        type="text" name="name" value="{{ old('name', $edition->name) }}"
                                        placeholder="ex: Calan'Couleurs 2K26" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                                </div>
                            </div>

                            <!-- URL de l'édition -->
                            <div class="space-y-2">
                                <x-input-label for="reservation_url" class="text-sm font-medium text-gray-700">URL de
                                    réservation</x-input-label>
                                <div class="view-mode">
                                    @if ($edition->reservation_url)
                                        <a href="{{ $edition->reservation_url }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 hover:underline break-all">
                                            <span>{{ str($edition->reservation_url)->limit(70) }}</span>
                                            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                        </a>
                                    @else
                                        <p class="text-gray-500">Non définie</p>
                                    @endif
                                </div>
                                <div class="edit-mode" style="display: none;">
                                    <x-text-input id="reservation_url"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        name="reservation_url" type="url" value="{{ old('reservation_url', $edition->reservation_url ?? '') }}"
                                        autocomplete="url" placeholder="https://reservation.example.com" />
                                    <x-input-error :messages="$errors->get('reservation_url')" class="mt-1" />
                                </div>
                            </div>
                        </div>

                        <!-- Dates et horaires -->
                        <div class="space-y-6 col-span-2">
                            <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">Dates et horaires
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Date de début -->
                                <div class="space-y-2">
                                    <x-input-label for="begin_date" class="text-sm font-medium text-gray-700">Début du
                                        festival <span class="text-red-500">*</span></x-input-label>
                                    <div class="view-mode">
                                        @if ($edition->formatted_begin_date)
                                            <p class="text-gray-900 font-mono">{{ $edition->formatted_begin_date }}</p>
                                        @else
                                            <p class="text-gray-400 italic">Non défini</p>
                                        @endif
                                    </div>
                                    <div class="edit-mode" style="display: none;">
                                        <x-text-input id="begin_date"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            type="datetime-local" name="begin_date" value="{{ old('begin_date', $edition->begin_date) }}"
                                            required />
                                        <x-input-error :messages="$errors->get('begin_date')" class="mt-1" />
                                    </div>
                                </div>

                                <!-- Date de fin -->
                                <div class="space-y-2">
                                    <x-input-label for="ending_date" class="text-sm font-medium text-gray-700">Fin du
                                        festival <span class="text-red-500">*</span></x-input-label>
                                    <div class="view-mode">
                                        @if ($edition->formatted_ending_date)
                                            <p class="text-gray-900 font-mono">{{ $edition->formatted_ending_date }}</p>
                                        @else
                                            <p class="text-gray-400 italic">Non défini</p>
                                        @endif
                                    </div>
                                    <div class="edit-mode" style="display: none;">
                                        <x-text-input id="ending_date"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            type="datetime-local" name="ending_date" value="{{ old('ending_date', $edition->ending_date) }}"
                                            required />
                                        <x-input-error :messages="$errors->get('ending_date')" class="mt-1" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statut & Configuration -->
                        <div class="space-y-6 col-span-2">
                            <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">
                                Statut & Configuration
                            </h3>

                            <!-- Statut -->
                            <div class="space-y-2">
                                <x-input-label for="status" class="text-sm font-medium text-gray-700">Statut <span
                                        class="text-red-500">*</span></x-input-label>
                                <div class="view-mode">
                                    <span
                                        class="items-stretch inline-flex gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-{{ $edition->statusColor }}-100 text-{{ $edition->statusColor }}-800">
                                        <i class="{{ $edition->statusIcon }} mr-1 self-center"></i>
                                        <span class="self-center">{{ $edition->statusLabel }}</span>
                                    </span>
                                </div>
                                <div class="edit-mode" style="display: none;">
                                    <select id="status" name="status" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="draft"
                                            {{ $edition->statusLabel === 'En projet' ? 'selected' : '' }}>En
                                            projet</option>
                                        <option value="upcoming"
                                            {{ $edition->statusLabel === 'À venir' ? 'selected' : '' }}>À
                                            venir</option>
                                        <option value="ongoing"
                                            {{ $edition->statusLabel === 'En cours' ? 'selected' : '' }}>En
                                            cours</option>
                                        <option value="past" {{ $edition->statusLabel === 'Passée' ? 'selected' : '' }}>
                                            Passée
                                        </option>
                                        <option value="archived"
                                            {{ $edition->statusLabel === 'Archivée' ? 'selected' : '' }}>
                                            Archivée</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-1" />

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
                            <div class="space-y-2">
                                <x-input-label for="actif" class="text-sm font-medium text-gray-700">Visibilité <span
                                        class="text-red-500">*</span></x-input-label>
                                <div class="view-mode">
                                    @if ($edition->actif)
                                        <span
                                            class="items-stretch inline-flex gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fa-solid fa-check self-center"></i>
                                            <span class="self-center">Actif</span>
                                        </span>
                                    @else
                                        <span
                                            class="items-stretch inline-flex gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fa-solid fa-xmark self-center"></i>
                                            <span class="self-center">Inactif</span>
                                        </span>
                                    @endif
                                </div>
                                <div class="edit-mode" style="display: none;">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <!-- Option Active -->
                                        <label
                                            class="relative flex items-center p-4 bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl cursor-pointer hover:shadow-md transition-all group">
                                            <input class="sr-only peer" type="radio" name="actif" value="1"
                                                {{ $edition->actif ? 'checked' : '' }}>
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
                                            <input class="sr-only peer" type="radio" name="actif" value="0"
                                                {{ !$edition->actif ? 'checked' : '' }}>
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
                                                    <div class="text-xs text-orange-700 mt-1">Masquée au public
                                                    </div>
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
                </div>

                <!-- Actions en mode édition -->
                <div class="edit-mode bg-gray-50 px-8 py-6 border-t border-gray-200 space-y-4" style="display: none;">

                    <!-- Boutons d'action -->
                    <div class="flex flex-col lg:flex-row lg:items-center gap-3">
                        <button type="button" onclick="toggleEditMode()"
                            class="w-full lg:w-auto bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors flex items-center justify-center lg:justify-start">
                            <i class="fa-solid fa-xmark mr-2"></i>
                            Annuler
                        </button>

                        <button type="submit"
                            class="w-full lg:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center justify-center lg:justify-start font-medium">
                            <i class="fa-solid fa-floppy-disk mr-2"></i>
                            Enregistrer les modifications
                        </button>
                    </div>

                    <!-- Infos de modification -->
                    <div class="pt-4 border-t border-gray-300">
                        <div class="text-sm text-gray-600 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info flex-shrink-0"></i>
                            <div class="flex flex-col sm:flex-row sm:gap-1">
                                <span>Dernière modification :</span>
                                <span class="font-medium">
                                    {{ $edition->formatted_updated_at }}
                                </span>
                                @if ($edition->updated_by_login)
                                    <span class="hidden sm:inline">par</span>
                                    <span class="font-medium">{{ $edition->updated_by_login }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Sections de gestion -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <!-- Artistes -->
                <a href="{{ route('admin.editions.performances.index', $edition->id) }}"
                    class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">Performances (artistes)</h4>
                            <p class="text-sm text-gray-500 mt-1">Gérez les performances des artistes d'une édition</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-microphone text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </a>

                <!-- Partenaires -->
                {{-- <a href="{{ route('admin.editions.partenaires', $edition->id) ?? '#' }}"
                    class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow"> --}}
                {{-- <a href="#"
                    class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">Partenaires</h4>
                            <p class="text-sm text-gray-500 mt-1">Gérer les partenaires</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-handshake text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </a> --}}

                <!-- Stands -->
                {{-- <a href="{{ route('admin.editions.stands', $edition->id) ?? '#' }}"
                    class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow"> --}}
                {{-- <a href="#"
                    class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">Stands</h4>
                            <p class="text-sm text-gray-500 mt-1">Gérer les stands</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-store text-orange-600 text-xl"></i>
                        </div>
                    </div>
                </a> --}}
            </div>
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

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('edition-form');
            const statusSelect = document.querySelector('select[name="status"]');
            const currentStatus = '{{ $edition->status }}';
            const existingEditions = @json($otherEditions);

            form.addEventListener('submit', function(e) {
                const newStatus = statusSelect.value;

                if (newStatus === currentStatus) {
                    return true;
                }

                let conflictingEditions = [];
                let warningMessage = '';

                if (newStatus === 'upcoming') {
                    conflictingEditions = existingEditions.filter(edition => ['upcoming', 'ongoing', 'past']
                        .includes(edition.status)
                    );
                    warningMessage =
                        'Toutes les éditions "À venir", "En cours" et "Passée" seront ARCHIVÉES.';
                } else if (newStatus === 'ongoing') {
                    conflictingEditions = existingEditions.filter(edition => ['upcoming', 'ongoing', 'past']
                        .includes(edition.status)
                    );
                    warningMessage =
                        'Toutes les éditions "À venir", "En cours" et "Passée" seront ARCHIVÉES.';
                } else if (newStatus === 'past') {
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

                    const currentLabel = statusLabels[currentStatus];
                    const newLabel = statusLabels[newStatus];
                    const editionsList = conflictingEditions.map(edition => {
                        const name = edition.name || `Édition ${edition.year}`;
                        const status = statusLabels[edition.status];
                        return `  • ${name} (${status})`;
                    }).join('\n');

                    const message = `⚠️ ATTENTION !\n\n` +
                        `Vous allez changer le statut de "${currentLabel}" vers "${newLabel}".\n\n` +
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
