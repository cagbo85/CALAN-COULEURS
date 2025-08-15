@extends('layouts.admin')

<head>
    <title>FAQ {{ $faq->id }} - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.faqs.index') }}"
                        class="flex items-center text-gray-600 hover:text-purple-600 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour à la liste
                    </a>

                    <div class="h-6 w-px bg-gray-300"></div>

                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">FAQ #{{ $faq->id }}</h1>
                        <p class="text-gray-600">
                            <span class="inline-flex items-center">
                                <i class="fas fa-sort-numeric-down mr-1"></i>
                                Ordre {{ $faq->ordre }}
                            </span>
                            @if ($faq->actif)
                                <span
                                    class="ml-3 inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-eye mr-1"></i> Active
                                </span>
                            @else
                                <span
                                    class="ml-3 inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-eye-slash mr-1"></i> Masquée
                                </span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-3">
                    <button id="toggle-edit-btn" onclick="toggleEditMode()"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                        <i class="fas fa-edit mr-2"></i>
                        <span id="edit-btn-text">Modifier</span>
                    </button>

                    <button onclick="maskFaq({{ $faq->id }}, '{{ addslashes($faq->question) }}')"
                        class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors flex items-center">
                        <i class="fas fa-eye-slash mr-2"></i>
                        Masquer
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">

                    <!-- Question -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-question-circle text-purple-600 mr-2"></i>
                                Question
                            </h2>
                        </div>

                        <!-- Mode lecture -->
                        <div id="question-view" class="prose prose-sm max-w-none">
                            <p class="text-gray-900 text-base leading-relaxed">{{ $faq->question }}</p>
                        </div>

                        <!-- Mode édition -->
                        <div id="question-edit" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Question</label>
                            <textarea id="question-input"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 resize-none"
                                rows="3" maxlength="500">{{ $faq->question }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">
                                <span id="question-counter">{{ strlen($faq->question) }}</span>/500 caractères
                            </p>
                        </div>
                    </div>

                    <!-- Réponse -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-comment-dots text-green-600 mr-2"></i>
                                Réponse
                            </h2>
                        </div>

                        <!-- Mode lecture -->
                        <div id="answer-view" class="prose prose-sm max-w-none">
                            <div class="text-gray-900 leading-relaxed whitespace-pre-line">{{ $faq->answer }}</div>
                        </div>

                        <!-- Mode édition -->
                        <div id="answer-edit" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Réponse</label>
                            <textarea id="answer-input"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                rows="8" placeholder="Réponse détaillée à la question...">{{ $faq->answer }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Utilisez des retours à la ligne pour structurer votre
                                réponse</p>
                        </div>
                    </div>

                    <div id="edit-actions" class="hidden bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-info-circle mr-1"></i>
                                Modifiez les champs ci-dessus puis enregistrez vos modifications.
                            </p>

                            <div class="flex space-x-3">
                                <button onclick="cancelEdit()"
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors">
                                    <i class="fas fa-times mr-2"></i>
                                    Annuler
                                </button>
                                <button onclick="saveChanges()"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition-colors">
                                    <i class="fas fa-save mr-2"></i>
                                    Enregistrer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">

                    <!-- Paramètres -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-cogs text-blue-600 mr-2"></i>
                            Paramètres
                        </h3>

                        <div class="space-y-4">
                            <!-- Statut -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                                <div class="flex items-center space-x-2">
                                    <button id="status-btn" onclick="toggleStatus()"
                                        class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors
                                               {{ $faq->actif ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        <i class="fas fa-{{ $faq->actif ? 'eye' : 'eye-slash' }} mr-2"></i>
                                        <span id="status-text">{{ $faq->actif ? 'Active' : 'Masquée' }}</span>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $faq->actif ? 'Cette FAQ est visible sur le site' : 'Cette FAQ est masquée du site' }}
                                </p>
                            </div>

                            <!-- Ordre -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ordre d'affichage</label>
                                <div class="flex items-center space-x-2">
                                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $faq->ordre }}
                                    </span>
                                    <button onclick="changeOrder('up')"
                                        class="p-1 text-gray-400 hover:text-purple-600 transition-colors">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                    <button onclick="changeOrder('down')"
                                        class="p-1 text-gray-400 hover:text-purple-600 transition-colors">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Plus le nombre est petit, plus la FAQ apparaît en haut
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-gray-600 mr-2"></i>
                            Informations
                        </h3>

                        <div class="space-y-3 text-sm">
                            <!-- Créé -->
                            <div class="flex justify-between">
                                <span class="text-gray-500">Créé le :</span>
                                <span class="text-gray-900">{{ $faq->created_at->format('d/m/Y à H:i') }}</span>
                            </div>

                            @if ($faq->createdBy)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Créé par :</span>
                                    <span class="text-gray-900">{{ $faq->createdBy->firstname }}
                                        {{ $faq->createdBy->lastname }}</span>
                                </div>
                            @endif

                            <!-- Modifié -->
                            <div class="flex justify-between">
                                <span class="text-gray-500">Modifié le :</span>
                                <span class="text-gray-900">{{ $faq->updated_at->format('d/m/Y à H:i') }}</span>
                            </div>

                            @if ($faq->updatedBy)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Modifié par :</span>
                                    <span class="text-gray-900">{{ $faq->updatedBy->firstname }}
                                        {{ $faq->updatedBy->lastname }}</span>
                                </div>
                            @endif

                            <!-- ID -->
                            <div class="flex justify-between">
                                <span class="text-gray-500">ID :</span>
                                <span class="text-gray-900 font-mono">#{{ $faq->id }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-eye text-purple-600 mr-2"></i>
                            Aperçu site
                        </h3>

                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <details class="group">
                                <summary class="flex justify-between items-center cursor-pointer list-none">
                                    <span
                                        class="font-medium text-gray-900 text-sm">{{ Str::limit($faq->question, 60) }}</span>
                                    <i
                                        class="fas fa-chevron-down text-gray-400 group-open:rotate-180 transition-transform"></i>
                                </summary>
                                <div class="mt-3 text-sm text-gray-700 leading-relaxed">
                                    {{ Str::limit($faq->answer, 100) }}
                                </div>
                            </details>
                        </div>

                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Aperçu de l'affichage sur le site public
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Formulaire caché pour les actions -->
    <form id="update-form" method="POST" action="{{ route('admin.faqs.update', $faq->id) }}" style="display: none;"
        novalidate>
        @csrf
        @method('PUT')
        <input type="hidden" name="question" id="form-question">
        <input type="hidden" name="answer" id="form-answer">
        <input type="hidden" name="actif" id="form-actif" value="{{ $faq->actif ? '1' : '0' }}">
        <input type="hidden" name="ordre" id="form-ordre" value="{{ $faq->ordre }}">
    </form>

    <form id="delete-form" method="POST" action="{{ route('admin.faqs.destroy', $faq->id) }}" style="display: none;"
        novalidate>
        @csrf
        @method('DELETE')
    </form>

    <!-- JavaScript -->
    <script>
        let editMode = false;
        let currentStatus = {{ $faq->actif ? 'true' : 'false' }};
        let currentOrder = {{ $faq->ordre }};

        // Toggle mode édition
        function toggleEditMode() {
            editMode = !editMode;

            if (editMode) {
                // Passer en mode édition
                document.getElementById('question-view').classList.add('hidden');
                document.getElementById('question-edit').classList.remove('hidden');
                document.getElementById('answer-view').classList.add('hidden');
                document.getElementById('answer-edit').classList.remove('hidden');
                document.getElementById('edit-actions').classList.remove('hidden');

                // Changer le bouton
                document.getElementById('toggle-edit-btn').className =
                    'bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center';
                document.getElementById('edit-btn-text').textContent = 'Annuler';

                // Focus sur la question
                document.getElementById('question-input').focus();

                // Initialiser les compteurs
                updateCharacterCount();
            } else {
                cancelEdit();
            }
        }

        // Annuler l'édition
        function cancelEdit() {
            editMode = false;

            document.getElementById('question-view').classList.remove('hidden');
            document.getElementById('question-edit').classList.add('hidden');
            document.getElementById('answer-view').classList.remove('hidden');
            document.getElementById('answer-edit').classList.add('hidden');
            document.getElementById('edit-actions').classList.add('hidden');

            document.getElementById('toggle-edit-btn').className =
                'bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center';
            document.getElementById('edit-btn-text').textContent = 'Modifier';

            document.getElementById('question-input').value = `{{ $faq->question }}`;
            document.getElementById('answer-input').value = `{{ $faq->answer }}`;
        }

        function saveChanges() {
            const question = document.getElementById('question-input').value.trim();
            const answer = document.getElementById('answer-input').value.trim();

            if (!question || !answer) {
                alert('La question et la réponse sont obligatoires.');
                return;
            }

            if (question.length > 500) {
                alert('La question ne peut pas dépasser 500 caractères.');
                return;
            }

            document.getElementById('form-question').value = question;
            document.getElementById('form-answer').value = answer;

            document.getElementById('update-form').submit();
        }

        function toggleStatus() {
            currentStatus = !currentStatus;

            const statusBtn = document.getElementById('status-btn');
            const statusText = document.getElementById('status-text');

            if (currentStatus) {
                statusBtn.className =
                    'flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors bg-green-100 text-green-800 hover:bg-green-200';
                statusText.textContent = 'Active';
                statusBtn.querySelector('i').className = 'fas fa-eye mr-2';
            } else {
                statusBtn.className =
                    'flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors bg-red-100 text-red-800 hover:bg-red-200';
                statusText.textContent = 'Masquée';
                statusBtn.querySelector('i').className = 'fas fa-eye-slash mr-2';
            }

            document.getElementById('form-actif').value = currentStatus ? '1' : '0';
            document.getElementById('form-question').value = `{{ $faq->question }}`;
            document.getElementById('form-answer').value = `{{ $faq->answer }}`;
            document.getElementById('update-form').submit();
        }

        function changeOrder(direction) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('admin.faqs.change-order', $faq->id) }}';
            form.style.display = 'none';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            const directionInput = document.createElement('input');
            directionInput.type = 'hidden';
            directionInput.name = 'direction';
            directionInput.value = direction;
            form.appendChild(directionInput);

            document.body.appendChild(form);
            form.submit();
        }

        function maskFaq(id, question) {
            if (confirm(
                    `Êtes-vous sûr de vouloir masquer la FAQ "${question}" ?\n\nElle ne sera plus visible sur le site.`
                )) {
                document.getElementById('delete-form').submit();
            }
        }

        function updateCharacterCount() {
            const questionInput = document.getElementById('question-input');
            const counter = document.getElementById('question-counter');

            questionInput.addEventListener('input', function() {
                counter.textContent = this.value.length;

                if (this.value.length > 500) {
                    counter.parentElement.classList.add('text-red-500');
                } else {
                    counter.parentElement.classList.remove('text-red-500');
                }
            });
        }

        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        document.getElementById('answer-input').addEventListener('input', function() {
            autoResize(this);
        });
    </script>

    <style>
        details summary::-webkit-details-marker {
            display: none;
        }

        .prose {
            color: inherit;
        }

        .prose p {
            margin: 0;
        }
    </style>
@endsection
