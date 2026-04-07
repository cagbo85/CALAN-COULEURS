@extends('layouts.admin')

<head>
    <title>Création d'un artiste - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">
            <!-- En-tête -->
            <div class="mb-6 space-y-2">
                <a href="{{ route('admin.artistes.index') }}"
                    class="bg-black bg-opacity-30 text-white px-4 py-2 rounded-lg hover:bg-opacity-50 transition-all items-center">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Créer un(e) nouvel(le) artiste</h1>
                <p class="text-gray-600 mt-2">Ajoutez un(e) nouvel(le) artiste au festival Calan'Couleurs</p>
            </div>

            <form action="{{ route('admin.artistes.store') }}" method="POST" enctype="multipart/form-data" novalidate>
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
                            <!-- Nom de l'artiste -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="name" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Nom d'artiste : <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="">
                                    <x-text-input id="name"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                        type="text" name="name" :value="old('name')" required autofocus
                                        autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Photo -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="photo" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Photo :
                                </x-input-label>
                                <div class="">
                                    <input id="photo"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100"
                                        type="file" name="photo" accept=".webp" :value="old('photo')" autofocus
                                        autocomplete="photo" />
                                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                                    <p class="mt-2 text-xs text-gray-500">
                                        ⚠️ Format WEBP uniquement (max. 4MB)
                                    </p>
                                    <p class="mt-2 text-xs text-gray-500">
                                        📁 Pas de fichier WEBP ? Convertir sur <a href="https://convertio.co/fr/jpg-webp/"
                                            target="_blank"
                                            class="text-purple-600 hover:text-purple-800 underline font-medium">
                                            Convertio.co
                                        </a> ou
                                        <a href="https://squoosh.app/" target="_blank"
                                            class="text-purple-600 hover:text-purple-800 underline font-medium">
                                            Squoosh.app
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <!-- Style musical -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="style" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Style musical :
                                </x-input-label>
                                <div class="">
                                    <x-text-input id="style"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                        type="text" name="style" :value="old('style')" required autofocus
                                        autocomplete="style"
                                        placeholder="ex: Rock alternatif, DJ set - hip-hop/house, Rap & électro mélodique..." />
                                    <x-input-error :messages="$errors->get('style')" class="mt-2" />
                                    <p class="mt-2 text-xs text-gray-500">
                                        <i class="fa-solid fa-lightbulb text-yellow-500 mr-1"></i>
                                        Vous pouvez ajouter plusieurs styles à la suite, par exemple : "DJ set - hip-hop,
                                        afro, house, rap"
                                    </p>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="description" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Description :
                                </x-input-label>
                                <div class="">
                                    <textarea id="description" name="description" rows="4"
                                        class="w-full min-w-full px-4 py-2.5 min-h-32 max-h-40 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                        placeholder="Décrivez l'univers musical de l'artiste...">{{ old('description') }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Liens de Streaming -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4"
                            style="background: linear-gradient(135deg, rgba(147,51,234,1) 0%, rgba(236,72,153,1) 100%);">
                            <h3 class="text-xl font-semibold text-white flex items-center">
                                <i class="fa-solid fa-music mr-3"></i>
                                Liens de streaming
                            </h3>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- SoundCloud -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="soundcloud_url" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    SoundCloud :
                                </x-input-label>
                                <div class="">
                                    <x-text-input id="soundcloud_url"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                        type="url" name="soundcloud_url" :value="old('soundcloud_url')"
                                        placeholder="https://soundcloud.com/artiste" />
                                    <x-input-error :messages="$errors->get('soundcloud_url')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Spotify -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="spotify_url" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Spotify :
                                </x-input-label>
                                <div class="">
                                    <x-text-input id="spotify_url"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                        type="url" name="spotify_url" :value="old('spotify_url')"
                                        placeholder="https://spotify.com/artiste" />
                                    <x-input-error :messages="$errors->get('spotify_url')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Youtube -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="youtube_url" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Youtube :
                                </x-input-label>
                                <div class="">
                                    <x-text-input id="youtube_url"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                        type="url" name="youtube_url" :value="old('youtube_url')"
                                        placeholder="https://youtube.com/artiste" />
                                    <x-input-error :messages="$errors->get('youtube_url')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Deezer -->
                            <div class="grid grid-cols-1 gap-4 items-start">
                                <x-input-label for="deezer_url" class="block text-sm font-medium text-gray-700 lg:pt-2">
                                    Deezer :
                                </x-input-label>
                                <div class="">
                                    <x-text-input id="deezer_url"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                                        type="url" name="deezer_url" :value="old('deezer_url')"
                                        placeholder="https://deezer.com/artiste" />
                                    <x-input-error :messages="$errors->get('deezer_url')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div
                        class="bg-white rounded-xl shadow-lg border border-gray-200 px-6 py-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                        <a href="{{ route('admin.artistes.index') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all">
                            <i class="fa-solid fa-xmark mr-2"></i>
                            Annuler
                        </a>

                        <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg transition-colors items-center font-medium">
                            <i class="fa-solid fa-floppy-disk mr-2"></i>
                            Enregistrer l'artiste
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
