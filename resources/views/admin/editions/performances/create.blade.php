@extends('layouts.admin')

<head>
    <title>Création d'une performance - {{ $edition->name ?? 'Édition ' . $edition->year }} - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">
            <div class="mb-6 space-y-2">
                <a href="{{ route('admin.editions.performances.index', $edition->id) }}"
                    class="bg-black bg-opacity-30 text-white px-4 py-2 rounded-lg hover:bg-opacity-50 transition-all items-center">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Retour aux performances
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Créer une nouvelle performance</h1>
                <p class="text-gray-600 mt-2">Ajoutez une nouvelle performance pour l'édition
                    {{ $edition->name ?? 'Édition ' . $edition->year }} du festival Calan'Couleurs</p>
            </div>

            <form id="performance-form" action="{{ route('admin.editions.performances.store', $edition->id) }}" method="post"
                enctype="multipart/form-data" novalidate>
                @csrf
                <div class="space-y-6">
                    <!-- Artiste -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4"
                            style="background: linear-gradient(135deg, rgba(147,51,234,1) 0%, rgba(236,72,153,1) 100%);">
                            <h3 class="text-xl font-semibold text-white flex items-center">
                                <i class="fa-solid fa-user mr-3"></i>
                                Artiste concerné(e)
                            </h3>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Artiste -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="artiste_id" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Artiste : <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="">
                                    <select id="artiste_id" name="artiste_id" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                        <option value="">Sélectionnez un(e) artiste...</option>
                                        @foreach ($artistes as $artiste)
                                            <option value="{{ $artiste->id }}"
                                                {{ old('artiste_id') == $artiste->id ? 'selected' : '' }}>
                                                {{ $artiste->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('artiste_id')" class="mt-2" />

                                    <!-- Aide contextuelle -->
                                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                        <div class="flex gap-2">
                                            <i class="fa-solid fa-lightbulb text-blue-600 flex-shrink-0 mt-0.5"></i>
                                            <div class="text-xs text-blue-700 space-y-2">
                                                <p class="font-semibold text-sm">Si vous ne voyez pas votre artiste dans la
                                                    liste ?</p>
                                                <p class="text-blue-900">Si l'artiste n'existe pas encore, créez-le d'abord,
                                                    puis revenez ici
                                                    pour l'ajouter à la performance. <a
                                                        href="{{ route('admin.artistes.create') }}"
                                                        class="text-[#1D4ED8] underline">Ajouter
                                                        l'artiste</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
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

                            <!-- Jour de la performance -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="day" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Jour de la performance :
                                </x-input-label>
                                <div class="">
                                    <select id="day" name="day" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                        <option value="">Sélectionnez un jour...</option>
                                        <option value="Lundi" {{ old('day') == 'Lundi' ? 'selected' : '' }}>
                                            Lundi
                                        </option>
                                        <option value="Mardi" {{ old('day') == 'Mardi' ? 'selected' : '' }}>
                                            Mardi
                                        </option>
                                        <option value="Mercredi" {{ old('day') == 'Mercredi' ? 'selected' : '' }}>
                                            Mercredi
                                        </option>
                                        <option value="Jeudi" {{ old('day') == 'Jeudi' ? 'selected' : '' }}>
                                            Jeudi
                                        </option>
                                        <option value="Vendredi" {{ old('day') == 'Vendredi' ? 'selected' : '' }}>
                                            Vendredi
                                        </option>
                                        <option value="Samedi" {{ old('day') == 'Samedi' ? 'selected' : '' }}>
                                            Samedi
                                        </option>
                                        <option value="Dimanche" {{ old('day') == 'Dimanche' ? 'selected' : '' }}>
                                            Dimanche
                                        </option>
                                    </select>
                                    <x-input-error :messages="$errors->get('day')" class="mt-2" />

                                    <!-- Aide contextuelle -->
                                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                        <div class="flex gap-2"> <i
                                                class="fa-solid fa-lightbulb text-blue-600 flex-shrink-0 mt-0.5"></i>
                                            <div class="text-xs text-blue-700 space-y-2">
                                                <p class="font-semibold text-sm">Comment choisir le bon jour de
                                                    représentation :</p>
                                                <ul class="space-y-1.5 ml-2">
                                                    <li> Le bon jour à sélectionner est celui de la soirée de programmation.
                                                    </li>
                                                    <li> Si l'artiste performe après minuit mais fait partie de la nuit
                                                        précédente, gardez le jour précédent. </li>
                                                    <li> Exemple : L'artiste X est annoncé pour le vendredi mais performe à
                                                        02h00 le samedi, alors il faut mettre "vendredi" (nuit de vendredi).
                                                        Si l'artiste Y est annoncé pour le samedi mais performe à 01h00 le
                                                        dimanche, alors il faut mettre "samedi" (nuit de samedi). </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Scène -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="scene" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Scène :
                                </x-input-label>
                                <div class="">
                                    <select id="scene" name="scene" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                        <option value="">Sélectionnez une scène...</option>
                                        <option value="Extérieur" {{ old('scene') == 'Extérieur' ? 'selected' : '' }}>
                                            Extérieur
                                        </option>
                                        <option value="Intérieur" {{ old('scene') == 'Intérieur' ? 'selected' : '' }}>
                                            Intérieur
                                        </option>
                                    </select>
                                    <x-input-error :messages="$errors->get('scene')" class="mt-2" />
                                </div>
                            </div>
                            <!-- Date de début -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="begin_date" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Début de la performance :
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
                                    Fin de la performance :
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
                                                    La visibilité contrôle si la performance apparaît sur le site public
                                                    (programmation, etc.).
                                                </p>
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
                        <a href="{{ route('admin.editions.performances.index', $edition->id) }}"
                            class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all">
                            <i class="fa-solid fa-xmark mr-2"></i>
                            Annuler
                        </a>

                        <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg transition-colors flex items-center font-medium">
                            <i class="fa-solid fa-floppy-disk mr-2"></i>
                            Enregistrer la performance
                        </button>
                    </div>
            </form>
        </div>
    </main>
@endsection
