@extends('layouts.admin')

<head>
    <title>Création d'une FAQ - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">
            <form action="{{ route('admin.faqs.store') }}" method="POST" novalidate
                class="bg-white rounded-xl shadow-lg overflow-hidden">
                @csrf

                <div class="p-8 space-y-8">
                    <div class="border-b border-gray-200 pb-8">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                            {{-- <i class="fas fa-question-circle text-purple-500 mr-3"></i> --}}
                            Informations principales
                        </h3>

                        <!-- Question -->
                        <div class="flex flex-row space-x-4 items-start mt-4">
                            <x-input-label for="question" class="w-48 mt-3">
                                Question : <span class="text-red-500">*</span>
                            </x-input-label>
                            <div class="flex flex-col">
                                <textarea id="question" name="question" rows="3" required
                                    class="border-b bg-slate-50 px-3 py-2 rounded-md border-gray-300 mt-1 block w-96 focus:border-purple-500 focus:ring-purple-500"
                                    placeholder="Posez votre question ici...">{{ old('question') }}</textarea>
                                <x-input-error :messages="$errors->get('question')" class="mt-2" />

                                <div class="mt-2 flex justify-between items-center">
                                    <p class="text-xs text-gray-500">
                                        💡 Formulez une question claire et concise
                                    </p>
                                    <span id="question-count" class="text-xs text-gray-400">0/500</span>
                                </div>
                            </div>
                            <x-input-label for="question" :value="__('La question que se posent fréquemment les visiteurs')" />
                        </div>

                        <!-- Réponse -->
                        <div class="flex flex-row space-x-4 items-start mt-6">
                            <x-input-label for="answer" class="w-48 mt-3">
                                Réponse : <span class="text-red-500">*</span>
                            </x-input-label>
                            <div class="flex flex-col">
                                <textarea id="answer" name="answer" rows="6" required
                                    class="border-b bg-slate-50 px-3 py-2 rounded-md border-gray-300 mt-1 block w-96 focus:border-purple-500 focus:ring-purple-500"
                                    placeholder="Rédigez une réponse complète et utile...">{{ old('answer') }}</textarea>
                                <x-input-error :messages="$errors->get('answer')" class="mt-2" />

                                <div class="mt-2 space-y-1">
                                    <div class="flex justify-between items-center">
                                        <p class="text-xs text-gray-500">
                                            💡 Réponse détaillée et utile pour les visiteurs
                                        </p>
                                        <span id="answer-count" class="text-xs text-gray-400">0/2000</span>
                                    </div>
                                    {{-- <p class="text-xs text-blue-600 max-w-96">
                                        ✨ Vous pouvez utiliser du HTML simple : &lt;strong&gt;, &lt;em&gt;, &lt;br&gt;,
                                        &lt;a href=""&gt;
                                    </p> --}}
                                </div>
                            </div>
                            <x-input-label for="answer" :value="__('Réponse complète et détaillée à la question')" />
                        </div>
                    </div>

                    <div class="border-b border-gray-200 pb-8">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                            {{-- <i class="fas fa-cogs text-purple-500 mr-3"></i> --}}
                            Configuration et ordre
                        </h3>

                        <!-- Ordre d'affichage -->
                        <div class="flex flex-row space-x-4 items-center mt-4">
                            <x-input-label for="ordre" :value="__('Ordre d\'affichage :')" class="w-48" />
                            <div class="flex flex-col">
                                <x-text-input id="ordre"
                                    class="border-b bg-slate-50 px-3 py-2 rounded-md border-gray-300 mt-1 block w-96"
                                    type="number" name="ordre" :value="old('ordre', $nextOrder ?? 1)" min="1" max="999"
                                    placeholder="Position dans la liste" />
                                <x-input-error :messages="$errors->get('ordre')" class="mt-2" />

                                <div class="mt-2 space-y-1 max-w-96">
                                    <p class="text-xs text-gray-500">
                                        📋 Plus le numéro est petit, plus la FAQ apparaît en haut de la liste
                                    </p>
                                    <p class="text-xs text-purple-600">
                                        💡 Ordre suggéré : {{ $nextOrder ?? 1 }} (prochaine position disponible)
                                    </p>
                                    <div class="flex items-start space-x-1 bg-blue-50 rounded px-2 py-1">
                                        <span class="text-xs">🔄</span>
                                        <p class="text-xs text-blue-700">
                                            <strong>Décalage automatique :</strong> Si vous choisissez un ordre occupé (ex:
                                            3), les FAQs suivantes sont décalées automatiquement (3→4, 4→5, etc.)
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <x-input-label for="ordre" :value="__('Position de la FAQ dans la liste publique')" />
                        </div>

                        <!-- Statut de publication -->
                        <div class="flex flex-row space-x-4 items-center mt-6">
                            <x-input-label for="actif" :value="__('Publication :')" class="w-48" />
                            <div class="flex flex-col">
                                <div class="mt-1 flex items-start space-x-4">
                                    <label
                                        class="flex items-center bg-green-50 p-3 rounded-lg border-2 border-green-200 hover:border-green-300 cursor-pointer transition-colors">
                                        <input type="radio" name="actif" value="1"
                                            {{ old('actif', '1') == '1' ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-green-900">
                                                <i class="fas fa-eye mr-1"></i> Publier immédiatement
                                            </div>
                                            <div class="text-xs text-green-700">La FAQ sera visible sur le site</div>
                                        </div>
                                    </label>

                                    <label
                                        class="flex items-center bg-orange-50 p-3 rounded-lg border-2 border-orange-200 hover:border-orange-300 cursor-pointer transition-colors">
                                        <input type="radio" name="actif" value="0"
                                            {{ old('actif') == '0' ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-orange-600 shadow-sm focus:border-orange-300 focus:ring focus:ring-orange-200 focus:ring-opacity-50">
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-orange-900">
                                                <i class="fas fa-eye-slash mr-1"></i> Enregistrer en brouillon
                                            </div>
                                            <div class="text-xs text-orange-700">FAQ masquée, non visible sur le site</div>
                                        </div>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('actif')" class="mt-2" />
                            </div>
                            <x-input-label for="actif" :value="__('Visibilité de la FAQ sur le site public')" />
                        </div>
                    </div>

                    <div>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                            {{-- <i class="fas fa-eye text-purple-500 mr-3"></i> --}}
                            Aperçu en temps réel
                        </h3>

                        <div class="bg-gray-50 rounded-lg p-6 border-2 border-dashed border-gray-300">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="border-l-4 border-purple-500 pl-4">
                                    <h4 class="font-semibold text-gray-900 mb-2" id="preview-question">
                                        Votre question apparaîtra ici...
                                    </h4>
                                    <div class="text-gray-700 leading-relaxed" id="preview-answer">
                                        Votre réponse apparaîtra ici...
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-3 text-center">
                                ⬆️ Aperçu de votre FAQ tel qu'elle apparaîtra sur le site public
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-8 py-6 border-t border-gray-200 flex items-center justify-between">
                    <a href="{{ route('admin.faqs.index') }}"
                        class="text-gray-600 hover:text-gray-800 transition-colors flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>

                    <button type="submit"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg transition-colors flex items-center font-medium">
                        <i class="fas fa-save mr-2"></i>
                        Enregistrer la FAQ
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionInput = document.getElementById('question');
            const answerInput = document.getElementById('answer');
            const previewQuestion = document.getElementById('preview-question');
            const previewAnswer = document.getElementById('preview-answer');
            const questionCount = document.getElementById('question-count');
            const answerCount = document.getElementById('answer-count');

            function updatePreview() {
                const question = questionInput.value.trim();
                const answer = answerInput.value.trim();

                previewQuestion.textContent = question || 'Votre question apparaîtra ici...';
                previewAnswer.innerHTML = answer || 'Votre réponse apparaîtra ici...';

                questionCount.textContent = `${question.length}/500`;
                answerCount.textContent = `${answer.length}/2000`;

                questionCount.className = question.length > 450 ? 'text-xs text-red-500 font-medium' :
                    'text-xs text-gray-400';
                answerCount.className = answer.length > 1800 ? 'text-xs text-red-500 font-medium' :
                    'text-xs text-gray-400';
            }

            questionInput.addEventListener('input', updatePreview);
            answerInput.addEventListener('input', updatePreview);

            updatePreview();
        });
    </script>
@endsection
