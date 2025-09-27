@extends('layouts.admin')

<head>
    <title>{{ $artiste->name }} - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="relative h-48" style="background: linear-gradient(135deg, rgba(147,51,234,1) 0%, rgba(236,72,153,1) 100%);">
                    <div class="absolute top-4 left-4">
                        <a href="{{ route('admin.artistes.index') }}"
                            class="bg-black bg-opacity-30 text-white px-4 py-2 rounded-lg hover:bg-opacity-50 transition-all flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour à la liste
                        </a>
                    </div>

                    <!-- Actions -->
                    <div class="absolute top-4 right-4 flex space-x-2">
                        <button type="button" onclick="toggleEditMode()" id="edit-btn"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center">
                            <i class="fas fa-edit mr-2"></i>
                            Modifier
                        </button>
                        <button type="button" onclick="maskArtist()"
                            class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors flex items-center">
                            <i class="fas fa-eye-slash mr-2"></i>
                            Masquer
                        </button>
                        <button type="button" onclick="toggleEditMode()" id="cancel-btn" style="display: none;"
                            class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </button>
                    </div>
                </div>

                <!-- Profil artiste -->
                <div class="relative px-6 pb-6">
                    <div class="flex items-end -mt-16">
                        <!-- Photo artiste -->
                        <div class="relative">
                            @if ($artiste->photo)
                                <img src="{{ asset($artiste->photo) }}" alt="{{ $artiste->name }}"
                                    class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                            @else
                                <div
                                    class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-microphone text-purple-600 text-3xl"></i>
                                </div>
                            @endif

                            <!-- Badge statut -->
                            <div class="absolute -bottom-2 -right-2">
                                @if ($artiste->actif)
                                    <span
                                        class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium flex items-center">
                                        <i class="fas fa-check mr-1"></i> Actif
                                    </span>
                                @else
                                    <span
                                        class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-medium flex items-center">
                                        <i class="fas fa-times mr-1"></i> Inactif
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Info artiste -->
                        <div class="ml-6 flex-1">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $artiste->name }}</h1>
                            @if ($artiste->style)
                                <p class="text-lg text-purple-600 font-medium">{{ $artiste->style }}</p>
                            @endif

                            <!-- Programmation rapide -->
                            @if ($artiste->day || $artiste->scene)
                                <div class="mt-2 flex items-center text-sm text-gray-600">
                                    @if ($artiste->day)
                                        <i class="fas fa-calendar mr-1"></i>
                                        <span class="capitalize">{{ $artiste->day }}</span>
                                    @endif
                                    @if ($artiste->day && $artiste->scene)
                                        <span class="mx-2">•</span>
                                    @endif
                                    @if ($artiste->scene)
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        <span>{{ $artiste->scene }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.artistes.update', $artiste->id) }}" method="POST" enctype="multipart/form-data"
                id="artiste-form" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" novalidate>
                @csrf
                @method('PUT')

                <div class="p-8 space-y-8">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">
                                Informations générales
                            </h3>

                            <!-- Nom -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Nom d'artiste</label>
                                <div class="view-mode">
                                    <p class="text-lg text-gray-900">{{ $artiste->name }}</p>
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
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">{{ $artiste->description }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                                </div>
                            </div>
                        </div>

                        <!-- Programmation -->
                        <div class="space-y-6">
                            <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">
                                Programmation
                            </h3>

                            <!-- Jour -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Jour</label>
                                <div class="view-mode">
                                    @if ($artiste->day)
                                        <span
                                            class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium capitalize">
                                            {{ $artiste->day }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic">Non programmé</span>
                                    @endif
                                </div>
                                <div class="edit-mode" style="display: none;">
                                    <select name="day"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        <option value="">Sélectionnez un jour</option>
                                        <option value="Vendredi" {{ $artiste->day == 'Vendredi' ? 'selected' : '' }}>
                                            Vendredi</option>
                                        <option value="Samedi" {{ $artiste->day == 'Samedi' ? 'selected' : '' }}>Samedi
                                        </option>
                                        <option value="Dimanche" {{ $artiste->day == 'Dimanche' ? 'selected' : '' }}>
                                            Dimanche</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('day')" class="mt-1" />
                                </div>
                            </div>

                            <!-- Horaires -->
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Début -->
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Début</label>
                                    <div class="view-mode">
                                        <p class="text-gray-900 font-mono">
                                            {{ \Carbon\Carbon::parse($artiste->begin_date)->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="edit-mode" style="display: none;">
                                        <input type="datetime-local" name="begin_date"
                                            value="{{ \Carbon\Carbon::parse($artiste->begin_date)->format('Y-m-d\TH:i') }}"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        <x-input-error :messages="$errors->get('begin_date')" class="mt-1" />
                                    </div>
                                </div>

                                <!-- Fin -->
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-gray-700">Fin</label>
                                    <div class="view-mode">
                                        <p class="text-gray-900 font-mono">
                                            {{ \Carbon\Carbon::parse($artiste->ending_date)->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="edit-mode" style="display: none;">
                                        <input type="datetime-local" name="ending_date"
                                            value="{{ \Carbon\Carbon::parse($artiste->ending_date)->format('Y-m-d\TH:i') }}"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        <x-input-error :messages="$errors->get('ending_date')" class="mt-1" />
                                    </div>
                                </div>
                            </div>

                            <!-- Scène -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Scène</label>
                                <div class="view-mode">
                                    @if ($artiste->scene)
                                        <span
                                            class="inline-block bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                                            {{ $artiste->scene }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 italic">Non définie</span>
                                    @endif
                                </div>
                                <div class="edit-mode" style="display: none;">
                                    <input type="text" name="scene" value="{{ $artiste->scene }}"
                                        placeholder="ex: Scène Principale"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                    <x-input-error :messages="$errors->get('scene')" class="mt-1" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Liens de streaming -->
                    <div class="border-t border-gray-200 pt-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Liens de streaming</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach (['soundcloud_url' => ['SoundCloud', 'fab fa-soundcloud', 'orange'], 'spotify_url' => ['Spotify', 'fab fa-spotify', 'green'], 'youtube_url' => ['YouTube', 'fab fa-youtube', 'red'], 'deezer_url' => ['Deezer', 'fas fa-music', 'purple']] as $field => $info)
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
                                                <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">Non renseigné</span>
                                        @endif
                                    </div>
                                    <div class="edit-mode" style="display: none;">
                                        <input type="url" name="{{ $field }}" value="{{ $artiste->$field }}"
                                            placeholder="https://..."
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        <x-input-error :messages="$errors->get($field)" class="mt-1" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Média et statut</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                            <!-- Statut -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Statut</label>
                                <div class="edit-mode" style="display: none;">
                                    <div class="flex items-center">
                                        <input type="hidden" name="actif" value="0">
                                        <input type="checkbox" name="actif" value="1"
                                            {{ $artiste->actif ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                        <label class="ml-2 text-sm text-gray-600">Artiste actif (visible sur le
                                            site)</label>
                                    </div>
                                    <x-input-error :messages="$errors->get('actif')" class="mt-1" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="edit-mode bg-gray-50 px-8 py-6 border-t border-gray-200 flex items-center justify-between"
                    style="display: none;">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Dernière modification par {{ $artiste->updatedBy?->firstname ?? 'Système' }}
                        le {{ $artiste->updated_at->format('d/m/Y à H:i') }}
                    </div>

                    <div class="flex space-x-4">
                        <button type="button" onclick="toggleEditMode()"
                            class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors flex items-center">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </button>

                        <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg transition-colors flex items-center font-medium">
                            <i class="fas fa-save mr-2"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <form id="mask-form" method="POST" action="{{ route('admin.artistes.destroy', $artiste->id) }}"
        style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    <script>
        function maskArtist() {
            if (confirm(
                    'Êtes-vous sûr de vouloir masquer cet artiste ?\n\nIl ne sera plus visible sur le site.'
                    )) {
                document.getElementById('mask-form').submit();
            }
        }

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
