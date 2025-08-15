@extends('layouts.admin')

<head>
    <title>Création d'un artiste - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">
            <form action="{{ route('admin.artistes.store') }}" method="POST" enctype="multipart/form-data" novalidate
                class="bg-white rounded-xl shadow-lg overflow-hidden">
                @csrf

                <div class="p-8 space-y-8">
                    <!-- Section 1: Informations générales -->
                    <div class="border-b border-gray-200 pb-8">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                            {{-- <i class="fas fa-microphone text-purple-500 mr-3"></i> --}}
                            Informations générales
                        </h3>

                        <!-- Nom de l'artiste -->
                        <div class="flex flex-row space-x-4 items-center mt-4">
                            <x-input-label for="name" class="w-48">
                                Nom d'artiste : <span class="text-red-500">*</span>
                            </x-input-label>
                            <div class="flex flex-col">
                                <x-text-input id="name"
                                    class="border-b bg-slate-50 px-1 rounded-md border-gray-300 mt-1 block w-96"
                                    type="text" name="name" :value="old('name')" required autofocus
                                    autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <x-input-label for="name" :value="__('Nom de scène de l\'artiste ou du groupe')" />
                        </div>

                        <!-- Style musical -->
                        <div class="flex flex-row space-x-4 items-center mt-4">
                            <x-input-label for="style" :value="__('Style musical :')" class="w-48" />
                            <div class="flex flex-col max-w-96">
                                <x-text-input id="style"
                                    class="border-b bg-slate-50 px-1 rounded-md border-gray-300 mt-1 block w-96"
                                    type="text" name="style" :value="old('style')" autocomplete="style"
                                    placeholder="ex: Rock alternatif, DJ set - hip-hop/house, Rap & électro mélodique..." />
                                <x-input-error :messages="$errors->get('style')" class="mt-2" />

                                <!-- Aide simple -->
                                <p class="text-xs text-gray-500 mt-1">
                                    💡 Vous pouvez ajouter plusieurs styles à la suite, par exemple : "DJ set – hip-hop,
                                    afro, house, rap"
                                </p>
                            </div>
                            <x-input-label for="style" :value="__('Décrivez le style musical de l\'artiste')" />
                        </div>

                        <!-- Description -->
                        <div class="flex flex-row space-x-4 items-start mt-4">
                            <x-input-label for="description" :value="__('Description :')" class="w-48 mt-3" />
                            <div class="flex flex-col">
                                <textarea id="description" name="description" rows="4"
                                    class="border-b bg-slate-50 px-1 rounded-md border-gray-300 mt-1 block w-96 focus:border-purple-500 focus:ring-purple-500"
                                    placeholder="Décrivez l'univers musical de l'artiste...">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                            <x-input-label for="description" :value="__('Biographie et description de l\'artiste')" />
                        </div>
                    </div>

                    <!-- Section 2: Programmation -->
                    <div class="border-b border-gray-200 pb-8">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                            {{-- <i class="fas fa-calendar-alt text-purple-500 mr-3"></i> --}}
                            Programmation
                        </h3>

                        <!-- Jour -->
                        <div class="flex flex-row space-x-4 items-center mt-4">
                            <x-input-label for="day" :value="__('Jour :')" class="w-48" />
                            <div class="flex flex-col">
                                <select id="day" name="day"
                                    class="border-b bg-slate-50 px-1 rounded-md border-gray-300 mt-1 block w-96 focus:border-purple-500 focus:ring-purple-500">
                                    <option value="">Sélectionnez un jour</option>
                                    <option value="Vendredi" {{ old('day') == 'Vendredi' ? 'selected' : '' }}>Vendredi
                                    </option>
                                    <option value="Samedi" {{ old('day') == 'Samedi' ? 'selected' : '' }}>Samedi</option>
                                    <option value="Dimanche" {{ old('day') == 'Dimanche' ? 'selected' : '' }}>Dimanche
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('day')" class="mt-2" />
                            </div>
                            <x-input-label for="day" :value="__('Jour de passage sur scène')" />
                        </div>

                        <!-- Date et heure de début -->
                        <div class="flex flex-row space-x-4 items-center mt-4">
                            <x-input-label for="begin_date" class="w-48">
                                Début : <span class="text-red-500">*</span>
                            </x-input-label>
                            <div class="flex flex-col">
                                <x-text-input id="begin_date"
                                    class="border-b bg-slate-50 px-1 rounded-md border-gray-300 mt-1 block w-96"
                                    type="datetime-local" name="begin_date" :value="old('begin_date')" required />
                                <x-input-error :messages="$errors->get('begin_date')" class="mt-2" />
                            </div>
                            <x-input-label for="begin_date" :value="__('Date et heure de début de représentation')" />
                        </div>

                        <!-- Date et heure de fin -->
                        <div class="flex flex-row space-x-4 items-center mt-4">
                            <x-input-label for="ending_date" class="w-48">
                                Fin : <span class="text-red-500">*</span>
                            </x-input-label>
                            <div class="flex flex-col">
                                <x-text-input id="ending_date"
                                    class="border-b bg-slate-50 px-1 rounded-md border-gray-300 mt-1 block w-96"
                                    type="datetime-local" name="ending_date" :value="old('ending_date')" required />
                                <x-input-error :messages="$errors->get('ending_date')" class="mt-2" />
                            </div>
                            <x-input-label for="ending_date" :value="__('Date et heure de fin de représentation')" />
                        </div>

                        <!-- Scène -->
                        <div class="flex flex-row space-x-4 items-center mt-4">
                            <x-input-label for="scene" :value="__('Scène :')" class="w-48" />
                            <div class="flex flex-col">
                                <x-text-input id="scene"
                                    class="border-b bg-slate-50 px-1 rounded-md border-gray-300 mt-1 block w-96"
                                    type="text" name="scene" :value="old('scene')" autocomplete="scene"
                                    placeholder="ex: Scène Principale" />
                                <x-input-error :messages="$errors->get('scene')" class="mt-2" />
                            </div>
                            <x-input-label for="scene" :value="__('Nom de la scène où se produira l\'artiste')" />
                        </div>
                    </div>

                    <!-- Section 3: Liens de streaming -->
                    <div class="border-b border-gray-200 pb-8">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                            {{-- <i class="fas fa-music text-purple-500 mr-3"></i> --}}
                            Liens de streaming
                        </h3>

                        <!-- SoundCloud -->
                        <div class="flex flex-row space-x-4 items-center mt-4">
                            <x-input-label for="soundcloud_url" :value="__('SoundCloud :')" class="w-48" />
                            <div class="flex flex-col">
                                <x-text-input id="soundcloud_url"
                                    class="border-b bg-slate-50 px-1 rounded-md border-gray-300 mt-1 block w-96"
                                    type="url" name="soundcloud_url" :value="old('soundcloud_url')"
                                    placeholder="https://soundcloud.com/artiste" />
                                <x-input-error :messages="$errors->get('soundcloud_url')" class="mt-2" />
                            </div>
                            <x-input-label for="soundcloud_url" :value="__('Lien vers le profil SoundCloud')" />
                        </div>

                        <!-- Spotify -->
                        <div class="flex flex-row space-x-4 items-center mt-4">
                            <x-input-label for="spotify_url" :value="__('Spotify :')" class="w-48" />
                            <div class="flex flex-col">
                                <x-text-input id="spotify_url"
                                    class="border-b bg-slate-50 px-1 rounded-md border-gray-300 mt-1 block w-96"
                                    type="url" name="spotify_url" :value="old('spotify_url')"
                                    placeholder="https://open.spotify.com/artist/..." />
                                <x-input-error :messages="$errors->get('spotify_url')" class="mt-2" />
                            </div>
                            <x-input-label for="spotify_url" :value="__('Lien vers le profil Spotify')" />
                        </div>

                        <!-- YouTube -->
                        <div class="flex flex-row space-x-4 items-center mt-4">
                            <x-input-label for="youtube_url" :value="__('YouTube :')" class="w-48" />
                            <div class="flex flex-col">
                                <x-text-input id="youtube_url"
                                    class="border-b bg-slate-50 px-1 rounded-md border-gray-300 mt-1 block w-96"
                                    type="url" name="youtube_url" :value="old('youtube_url')"
                                    placeholder="https://www.youtube.com/@artiste" />
                                <x-input-error :messages="$errors->get('youtube_url')" class="mt-2" />
                            </div>
                            <x-input-label for="youtube_url" :value="__('Lien vers la chaîne YouTube')" />
                        </div>

                        <!-- Deezer -->
                        <div class="flex flex-row space-x-4 items-center mt-4">
                            <x-input-label for="deezer_url" :value="__('Deezer :')" class="w-48" />
                            <div class="flex flex-col">
                                <x-text-input id="deezer_url"
                                    class="border-b bg-slate-50 px-1 rounded-md border-gray-300 mt-1 block w-96"
                                    type="url" name="deezer_url" :value="old('deezer_url')"
                                    placeholder="https://www.deezer.com/artist/..." />
                                <x-input-error :messages="$errors->get('deezer_url')" class="mt-2" />
                            </div>
                            <x-input-label for="deezer_url" :value="__('Lien vers le profil Deezer')" />
                        </div>
                    </div>

                    <!-- Section 4: Média et statut -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                            {{-- <i class="fas fa-image text-purple-500 mr-3"></i> --}}
                            Média et statut
                        </h3>

                        <!-- Photo -->
                        <div class="flex flex-row space-x-4 items-center mt-4">
                            <x-input-label for="photo" class="w-48">
                                Photo : <span class="text-red-500">*</span>
                            </x-input-label>
                            <div class="flex flex-col">
                                <input type="file" id="photo" name="photo" accept=".webp" required
                                    class="border-b bg-slate-50 px-1 rounded-md border-gray-300 mt-1 block w-96 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />

                                <!-- Infos et lien de conversion -->
                                <div class="mt-2 space-y-1">
                                    <p class="text-xs text-red-600 font-medium">⚠️ Format WEBP uniquement (max. 4MB) -
                                        OBLIGATOIRE</p>
                                    <p class="text-xs text-gray-500">
                                        📁 Pas de fichier WEBP ?
                                        <a href="https://convertio.co/fr/jpg-webp/" target="_blank"
                                            class="text-purple-600 hover:text-purple-800 underline font-medium">
                                            Convertir sur Convertio.co
                                        </a>
                                        ou
                                        <a href="https://squoosh.app/" target="_blank"
                                            class="text-purple-600 hover:text-purple-800 underline font-medium">
                                            Squoosh.app
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <x-input-label for="photo" :value="__('Photo de présentation de l\'artiste (obligatoire, format WEBP)')" />
                        </div>

                        <!-- Statut actif -->
                        <div class="flex flex-row space-x-4 items-center mt-4">
                            <x-input-label for="actif" :value="__('Statut :')" class="w-48" />
                            <div class="flex flex-col">
                                <div class="mt-1 flex items-center">
                                    <input type="hidden" name="actif" value="0">
                                    <input type="checkbox" id="actif" name="actif" value="1"
                                        {{ old('actif', true) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                    <label for="actif" class="ml-2 text-sm text-gray-600">Artiste actif (visible sur le
                                        site)</label>
                                </div>
                                <x-input-error :messages="$errors->get('actif')" class="mt-2" />
                            </div>
                            <x-input-label for="actif" :value="__('Visibilité de l\'artiste sur le site public')" />
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-8 py-6 border-t border-gray-200 flex items-center justify-between">
                    <a href="{{ route('admin.artistes.index') }}"
                        class="text-gray-600 hover:text-gray-800 transition-colors flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>

                    <div class="flex space-x-4">
                        <button type="submit" name="action" value="save"
                            class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg transition-colors flex items-center font-medium">
                            <i class="fas fa-save mr-2"></i>
                            Enregistrer l'artiste
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
