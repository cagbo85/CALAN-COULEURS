@extends('layouts.admin')

<head>
    <title>{{ $artiste->name }} - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="relative h-48"
                    style="background: linear-gradient(135deg, rgba(147,51,234,1) 0%, rgba(236,72,153,1) 100%);">
                    <div class="absolute inset-x-0 top-0 p-3 sm:p-4">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ route('admin.artistes.index') }}"
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

                <!-- Profil artiste -->
                <div class="relative px-6 pb-6">
                    <div class="flex flex-col sm:flex-row sm:items-end -mt-16 gap-6">
                        <!-- Photo artiste -->
                        <div class="relative flex justify-center flex-shrink-0">
                            @if ($artiste->photo)
                                <img src="{{ asset($artiste->photo) }}" alt="{{ $artiste->name }}"
                                    class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-white flex items-center justify-center object-cover">
                            @else
                                <div
                                    class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-white flex items-center justify-center object-cover">
                                    <i class="fa-solid fa-microphone text-purple-600 text-3xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Info artiste -->
                        <div class="flex-1 text-center sm:text-left">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $artiste->name }}</h1>

                            <!-- Aperçu du style -->
                            @if ($artiste->style)
                                <div class="mt-2 flex items-center text-sm text-gray-600">
                                    <i class="fa-solid fa-music mr-1"></i>
                                    <span>{{ $artiste->style }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('admin.artistes.update', $artiste->id) }}" method="POST" enctype="multipart/form-data"
                id="artiste-form" novalidate>
                @csrf
                @method('PUT')

                <div class="p-8 space-y-8 mb-6 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                    <!-- Informations -->
                    <div class="grid grid-cols-2 gap-8">

                        <!-- Informations générales -->
                        <div class="space-y-6 col-span-2">
                            <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">
                                Informations générales
                            </h3>

                            <!-- Nom -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Nom d'artiste <span
                                        class="text-red-500">*</span></label>
                                <div class="view-mode">
                                    <p class="text-lg font-semibold text-gray-900">{{ $artiste->name }}</p>
                                </div>
                                <div class="edit-mode" style="display: none;">
                                    <input type="text" name="name" value="{{ $artiste->name }}" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                                </div>
                            </div>

                            <!-- Style -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Style musical</label>
                                <div class="view-mode">
                                    @if ($artiste->style)
                                        <span
                                            class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                                            {{ $artiste->style }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic">Non défini</span>
                                    @endif
                                </div>
                                <div class="edit-mode" style="display: none;">
                                    <input type="text" name="style" value="{{ $artiste->style }}"
                                        placeholder="ex: DJ set – hip-hop, afro, house, rap"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                    <x-input-error :messages="$errors->get('style')" class="mt-1" />
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Description</label>
                                <div class="view-mode">
                                    @if ($artiste->description)
                                        <p class="text-gray-700 leading-relaxed">{{ $artiste->description }}</p>
                                    @else
                                        <span class="text-gray-400 italic">Aucune description</span>
                                    @endif
                                </div>
                                <div class="edit-mode" style="display: none;">
                                    <textarea name="description" rows="4" placeholder="Décrivez l'univers musical de l'artiste..."
                                        class="w-full px-3 py-2 min-h-32 max-h-40 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">{{ $artiste->description }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                                </div>
                            </div>
                        </div>

                        <!-- Liens de streaming -->
                        <div class="space-y-6 col-span-2">
                            <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">Liens de streaming
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach (['soundcloud_url' => ['SoundCloud', 'fa-brands fa-soundcloud', 'orange'], 'spotify_url' => ['Spotify', 'fa-brands fa-spotify', 'green'], 'youtube_url' => ['YouTube', 'fa-brands fa-youtube', 'red'], 'deezer_url' => ['Deezer', 'fa-brands fa-deezer', 'purple']] as $field => $info)
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-700 flex items-center">
                                            <i class="{{ $info[1] }} text-{{ $info[2] }}-600 mr-2"></i>
                                            {{ $info[0] }}
                                        </label>
                                        <div class="view-mode">
                                            @if ($artiste->$field)
                                                <a href="{{ $artiste->$field }}" target="_blank"
                                                    class="text-{{ $info[2] }}-600 hover:text-{{ $info[2] }}-800 underline flex items-center">
                                                    <i class="{{ $info[1] }} mr-2"></i>
                                                    Écouter sur {{ $info[0] }}
                                                    <i class="fa-solid fa-arrow-up-right-from-square ml-1 text-xs"></i>
                                                </a>
                                            @else
                                                <span class="text-gray-400 italic">Non renseigné</span>
                                            @endif
                                        </div>
                                        <div class="edit-mode" style="display: none;">
                                            <input type="url" name="{{ $field }}"
                                                value="{{ $artiste->$field }}" placeholder="https://..."
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                            <x-input-error :messages="$errors->get($field)" class="mt-1" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-6 col-span-2">
                            <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">Média
                            </h3>

                            <!-- Photo -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Photo</label>
                                <div class="edit-mode" style="display: none;">
                                    <input type="file" name="photo" accept=".webp"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                    <p class="text-xs text-gray-500 mt-1">Format WEBP uniquement (max. 4MB)</p>
                                    <x-input-error :messages="$errors->get('photo')" class="mt-1" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 space-y-8 mb-6 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="grid grid-cols-2 gap-8">
                        <div class="space-y-6 col-span-2">
                            <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">
                                Performances
                            </h3>

                            @if ($performances->isEmpty())
                                <div class="text-sm text-gray-500">
                                    Aucune performance associée à cet artiste.
                                </div>
                            @else
                                @foreach ($performances as $performance)
                                    <div class="p-4 bg-gray-200 rounded-lg">
                                        <input type="hidden" name="performances[{{ $performance->id }}][id]"
                                            value="{{ $performance->id }}">
                                        <!-- Nom de l'édition -->
                                        <h3 class="text-base font-semibold text-gray-900 border-b border-gray-200 pb-2">
                                            {{ $performance->edition_name ?? 'Édition ' . $performance->edition_year }}
                                            <span
                                                class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium border border-{{ $performance->statusColor }}-500 bg-{{ $performance->statusColor }}-100 text-{{ $performance->statusColor }}-800">
                                                {{ $performance->status }}
                                            </span>
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-2">
                                            <!-- Jour de représentation -->
                                            <div class="space-y-2 col-span-2">
                                                <label class="text-sm font-medium text-gray-700">Jour de
                                                    représentation</label>
                                                <div class="view-mode">
                                                    @if ($performance->day)
                                                        <p class="text-lg text-gray-900">
                                                            {{ $performance->day }}
                                                        </p>
                                                    @else
                                                        <span class="text-gray-400 italic">Non définie</span>
                                                    @endif
                                                </div>
                                                <div class="edit-mode" style="display: none;">
                                                    <select name="performances[{{ $performance->id }}][day]"
                                                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                                        <option value="">Sélectionnez un jour</option>
                                                        <option value="Lundi"
                                                            {{ $performance->day == 'Lundi' ? 'selected' : '' }}>
                                                            Lundi</option>
                                                        <option value="Mardi"
                                                            {{ $performance->day == 'Mardi' ? 'selected' : '' }}>
                                                            Mardi</option>
                                                        <option value="Mercredi"
                                                            {{ $performance->day == 'Mercredi' ? 'selected' : '' }}>
                                                            Mercredi</option>
                                                        <option value="Jeudi"
                                                            {{ $performance->day == 'Jeudi' ? 'selected' : '' }}>
                                                            Jeudi</option>
                                                        <option value="Vendredi"
                                                            {{ $performance->day == 'Vendredi' ? 'selected' : '' }}>
                                                            Vendredi</option>
                                                        <option value="Samedi"
                                                            {{ $performance->day == 'Samedi' ? 'selected' : '' }}>
                                                            Samedi</option>
                                                        <option value="Dimanche"
                                                            {{ $performance->day == 'Dimanche' ? 'selected' : '' }}>
                                                            Dimanche</option>
                                                    </select>
                                                    <x-input-error :messages="$errors->get(
                                                        'performances.' . $performance->id . '.day',
                                                    )" class="mt-1" />

                                                    <!-- Aide contextuelle -->
                                                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                                        <div class="flex gap-2"> <i
                                                                class="fa-solid fa-lightbulb text-blue-600 flex-shrink-0 mt-0.5"></i>
                                                            <div class="text-xs text-blue-700 space-y-2">
                                                                <p class="font-semibold text-sm">Comment choisir le bon jour de représentation :</p>
                                                                <ul class="space-y-1.5 ml-2">
                                                                    <li> Le bon jour à sélectionner est celui de la soirée de programmation.</li>
                                                                    <li> Si l'artiste performe après minuit mais fait partie de la nuit précédente, gardez le jour précédent. </li>
                                                                    <li> Exemple : L'artiste X est annoncé pour le vendredi mais performe à 02h00 le samedi, alors il faut mettre "vendredi" (nuit de vendredi). Si l'artiste Y est annoncé pour le samedi mais performe à 01h00 le dimanche, alors il faut mettre "samedi" (nuit de samedi). </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Horaires -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 col-span-2">
                                                <!-- Début -->
                                                <div class="space-y-2">
                                                    <label class="text-sm font-medium text-gray-700">Début</label>
                                                    <div class="view-mode">
                                                        @if ($performance->formatted_begin_date)
                                                            <p class="text-gray-900 font-mono">
                                                                {{ $performance->formatted_begin_date }}
                                                            </p>
                                                        @else
                                                            <span class="text-gray-400 italic">Non défini</span>
                                                        @endif
                                                    </div>
                                                    <div class="edit-mode" style="display: none;">
                                                        <input type="datetime-local"
                                                            name="performances[{{ $performance->id }}][begin_date]"
                                                            value="{{ $performance->begin_date }}"
                                                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                                        <x-input-error :messages="$errors->get(
                                                            'performances.' . $performance->id . '.begin_date',
                                                        )" class="mt-1" />
                                                    </div>
                                                </div>

                                                <!-- Fin -->
                                                <div class="space-y-2">
                                                    <label class="text-sm font-medium text-gray-700">Fin</label>
                                                    <div class="view-mode">
                                                        @if ($performance->formatted_ending_date)
                                                            <p class="text-gray-900 font-mono">
                                                                {{ $performance->formatted_ending_date }}
                                                            </p>
                                                        @else
                                                            <span class="text-gray-400 italic">Non défini</span>
                                                        @endif
                                                    </div>
                                                    <div class="edit-mode" style="display: none;">
                                                        <input type="datetime-local"
                                                            name="performances[{{ $performance->id }}][ending_date]"
                                                            value="{{ $performance->ending_date }}"
                                                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                                        <x-input-error :messages="$errors->get(
                                                            'performances.' . $performance->id . '.ending_date',
                                                        )" class="mt-1" />
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Scène -->
                                            <div class="space-y-2 col-span-2">
                                                <label class="text-sm font-medium text-gray-700">Scène</label>
                                                <div class="view-mode">
                                                    @if ($performance->scene)
                                                        <span
                                                            class="inline-block bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                                                            {{ $performance->scene }}
                                                        </span>
                                                    @else
                                                        <span class="text-gray-400 italic">Non définie</span>
                                                    @endif
                                                </div>
                                                <div class="edit-mode" style="display: none;">
                                                    <select name="performances[{{ $performance->id }}][scene]"
                                                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                                        <option value="">Sélectionnez une scène</option>
                                                        <option value="Extérieur"
                                                            {{ $performance->scene == 'Extérieur' ? 'selected' : '' }}>
                                                            Extérieur</option>
                                                        <option value="Intérieur"
                                                            {{ $performance->scene == 'Intérieur' ? 'selected' : '' }}>
                                                            Intérieur</option>
                                                    </select>
                                                    <x-input-error :messages="$errors->get(
                                                        'performances.' . $performance->id . '.scene',
                                                    )" class="mt-1" />
                                                </div>
                                            </div>

                                            <!-- Performance visible -->
                                            <div class="space-y-2 col-span-2">
                                                <label class="text-sm font-medium text-gray-700">Performance
                                                    visible</label>
                                                <div class="view-mode">
                                                    <span
                                                        class="items-stretch inline-flex gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-{{ $performance->actifColor }}-100 text-{{ $performance->actifColor }}-800">
                                                        <i class="{{ $performance->actifIcon }} self-center"></i>
                                                        <span class="self-center">{{ $performance->actifLabel }}</span>
                                                    </span>
                                                </div>
                                                <div class="edit-mode" style="display: none;">
                                                    <input type="hidden"
                                                        name="performances[{{ $performance->id }}][actif]"
                                                        value="0">
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                        <!-- Option Active -->
                                                        <label
                                                            class="bg-white relative flex items-center p-4 bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl cursor-pointer hover:shadow-md transition-all group">
                                                            <input type="radio"
                                                                name="performances[{{ $performance->id }}][actif]"
                                                                value="1" {{ $performance->actif ? 'checked' : '' }}
                                                                class="sr-only peer">
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
                                                                    <div class="text-xs text-green-700 mt-1">Visible
                                                                        publiquement</div>
                                                                </div>
                                                            </div>
                                                        </label>

                                                        <!-- Option Inactive -->
                                                        <label
                                                            class="bg-white relative flex items-center p-4 bg-gradient-to-br from-orange-50 to-red-50 border-2 border-orange-200 rounded-xl cursor-pointer hover:shadow-md transition-all group">
                                                            <input type="radio"
                                                                name="performances[{{ $performance->id }}][actif]"
                                                                value="0" {{ !$performance->actif ? 'checked' : '' }}
                                                                class="sr-only peer">
                                                            <div
                                                                class="absolute inset-0 border-2 border-orange-500 rounded-xl opacity-0 peer-checked:opacity-100 transition-opacity">
                                                            </div>
                                                            <div class="flex items-start gap-3 relative z-10">
                                                                <div
                                                                    class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                                                    <i class="fa-solid fa-eye-slash text-white"></i>
                                                                </div>
                                                                <div>
                                                                    <div class="font-semibold text-orange-900">Inactive
                                                                    </div>
                                                                    <div class="text-xs text-orange-700 mt-1">Masquée au
                                                                        public</div>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <x-input-error :messages="$errors->get(
                                                        'performances.' . $performance->id . '.actif',
                                                    )" class="mt-2" />

                                                    <!-- Aide contextuelle -->
                                                    <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                                        <div class="flex gap-2">
                                                            <i
                                                                class="fa-solid fa-eye text-amber-600 flex-shrink-0 mt-0.5"></i>
                                                            <div class="text-xs text-amber-800 space-y-2">
                                                                <p class="font-semibold text-sm">Comment fonctionne la
                                                                    visibilité ?</p>
                                                                <p class="text-amber-700">
                                                                    La visibilité contrôle si la performance apparaît sur le
                                                                    site public (remerciements, etc.).
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions en mode édition -->
                <div class="edit-mode bg-gray-50 pb-6 space-y-4" style="display: none;">

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

                    <!-- Infos de modification - En bas -->
                    <div class="pt-4 border-t border-gray-300">
                        <div class="text-sm text-gray-600 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info flex-shrink-0"></i>
                            <div class="flex flex-col sm:flex-row sm:gap-1">
                                <span>Dernière modification :</span>
                                <span class="font-medium">
                                    {{ $artiste->formatted_updated_at }}
                                </span>
                                @if ($artiste->updated_by_login)
                                    <span class="hidden sm:inline">par</span>
                                    <span class="font-medium">{{ $artiste->updated_by_login }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                toggleEditMode();
            @endif
        });

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
