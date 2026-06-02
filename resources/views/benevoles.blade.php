@extends('layouts.app')

@section('title', "Bénévoles - Calan'Couleurs Festival " . $currentEdition->year)

@section('content')
    <div class="w-full min-h-screen px-4 py-12 pt-8 sm:px-6 lg:px-8 bg-[#EEF1FF]">

        <div class="mx-auto mb-12 max-w-7xl">
            <div class="mb-8 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-[#1d3f89] mb-4">
                    Devenir bénévole pour Calan'Couleurs {{ $currentEdition->year }}
                </h1>
                <p class="max-w-2xl mx-auto text-lg text-gray-600">
                    Rejoins l'aventure en tant que bénévole et participe à la magie du festival les
                    {{ $currentEdition->formatted_dates_2 }}
                    à Campbon !
                </p>
            </div>

            <!-- Statistiques -->
            <div class="flex flex-wrap justify-center gap-4 mb-8">
                <div class="px-6 py-3 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">🎟️</span>
                        <span class="font-medium text-gray-600">Entrée gratuite</span>
                    </div>
                </div>
                <div class="px-6 py-3 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">👯</span>
                        <span class="font-medium text-gray-600">En binôme</span>
                    </div>
                </div>
                <div class="px-6 py-3 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">🎪</span>
                        <span class="font-medium text-gray-600">2 soirées</span>
                    </div>
                </div>
            </div>

            <!-- Navigation par onglets -->
            <div class="mb-8 border-b border-gray-200" style="position: relative; z-index: 5;">
                <nav class="flex flex-wrap justify-center space-x-1 sm:space-x-8" role="tablist">
                    <button
                        class="tab-button tab-active px-4 py-3 text-sm font-medium border-b-2 border-[#1d3f89] text-[#1d3f89] hover:text-[#8F1E98] hover:border-gray-300"
                        data-tab="principe" role="tab" aria-selected="true">
                        Le principe
                    </button>
                    <button
                        class="tab-button px-4 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-[#8F1E98] hover:border-gray-300"
                        data-tab="avantages" role="tab" aria-selected="false">
                        Les avantages
                    </button>
                    <button
                        class="tab-button px-4 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-[#8F1E98] hover:border-gray-300"
                        data-tab="inscription" role="tab" aria-selected="false">
                        S'inscrire
                    </button>
                </nav>
            </div>
        </div>

        <!-- Contenu des onglets -->
        <div class="mx-auto max-w-7xl">

            <!-- Onglet "Le principe" -->
            <div id="tab-principe" class="tab-content" role="tabpanel">
                <div class="mb-8">
                    <h2 class="mb-2 text-2xl font-bold text-gray-900">Le bénévolat en binôme</h2>
                    <p class="mb-6 text-gray-600">
                        Le bénévolat chez Calan'Couleurs, c'est une aventure à deux ! 👯
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 mb-10 md:grid-cols-2">
                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%);">
                            <h3 class="flex items-center gap-2 text-xl font-semibold text-white">
                                👯 Le concept binôme
                            </h3>
                        </div>
                        <div class="p-6 space-y-3 text-gray-700">
                            <p>
                                On ne vient pas bénévoler seul chez Calan'Couleurs ! Le principe est simple :
                                tu t'inscris <strong>avec un pote, un proche, quelqu'un que tu veux</strong> et vous
                                assurez la soirée ensemble, en binôme.
                            </p>
                            <p>
                                Ça veut dire que toute la soirée, vous êtes côte à côte sur votre poste. On partage les
                                tâches, on s'entraide, et on profite de l'ambiance du festival ensemble.
                                Pas question de se retrouver seul dans son coin !
                            </p>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%);">
                            <h3 class="flex items-center gap-2 text-xl font-semibold text-white">
                                🎪 Comment ça se passe ?
                            </h3>
                        </div>
                        <div class="p-6 space-y-3 text-gray-700">
                            <ul class="space-y-2">
                                <li class="flex items-start gap-2">
                                    <span class="text-[#1d3f89] font-bold">1.</span>
                                    Tu choisis ta soirée : <strong>vendredi ou samedi</strong>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-[#1d3f89] font-bold">2.</span>
                                    Tu t'inscris <strong>avec ton binôme</strong> via le formulaire HelloAsso
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-[#1d3f89] font-bold">3.</span>
                                    Vous assurez votre poste <strong>toute la soirée ensemble</strong>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-[#1d3f89] font-bold">4.</span>
                                    Vous profitez de l'ambiance et des artistes entre les créneaux 🎶
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button
                        class="px-6 py-3 font-semibold text-white transition-all duration-300 rounded-lg shadow tab-button-goto hover:shadow-lg"
                        data-goto="inscription" style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%)">
                        Je m'inscris avec mon binôme <i class="fa-solid fa-arrow-right fa-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Onglet "Les avantages" -->
            <div id="tab-avantages" class="hidden tab-content" role="tabpanel">
                <div class="mb-8">
                    <h2 class="mb-2 text-2xl font-bold text-gray-900">Ce que vous y gagnez</h2>
                    <p class="mb-6 text-gray-600">Des bénéfices concrets, et surtout une super expérience 🎉</p>
                </div>

                <div class="grid grid-cols-1 gap-6 mb-10 sm:grid-cols-2 lg:grid-cols-4">

                    <div class="flex flex-col items-start gap-3 p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <span class="text-4xl">🤙</span>
                        <h4 class="text-lg font-bold text-gray-900">Kiffer avec tes potes</h4>
                        <p class="text-sm text-gray-600">
                            On fonctionne par binôme de bénévoles. Donc ramène tes potes, on vous met ensemble toute la
                            soirée !
                        </p>
                    </div>

                    <div class="flex flex-col items-start gap-3 p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <span class="text-4xl">🔥</span>
                        <h4 class="text-lg font-bold text-gray-900">Vivre une expérience de folie</h4>
                        <p class="text-sm text-gray-600">
                            T'es bénévole un jour… pour profiter le deuxième ! Entrée gratuite incluse pour les deux
                            soirées.
                        </p>
                    </div>

                    <div class="flex flex-col items-start gap-3 p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <span class="text-4xl">😂</span>
                        <h4 class="text-lg font-bold text-gray-900">On se marre</h4>
                        <p class="text-sm text-gray-600">
                            On rigole beaucoup à Calan'Couleurs. L'ambiance dans l'équipe, c'est un truc à part, viens voir
                            par toi-même !
                        </p>
                    </div>

                    <div class="flex flex-col items-start gap-3 p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <span class="text-4xl">💘</span>
                        <h4 class="text-lg font-bold text-gray-900">Trouver l'âme sœur</h4>
                        <p class="text-sm text-gray-600">
                            On sait jamais… mais ça peut matcher à Calan. Les belles rencontres, ça commence souvent au
                            bénévolat. 😏
                        </p>
                    </div>

                </div>

                <div class="text-center">
                    <button
                        class="px-6 py-3 font-semibold text-white transition-all duration-300 rounded-lg shadow tab-button-goto hover:shadow-lg"
                        data-goto="inscription" style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%)">
                        Je m'inscris <i class="fa-solid fa-arrow-right fa-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Onglet "S'inscrire" -->
            <div id="tab-inscription" class="hidden tab-content" role="tabpanel">
                <div class="mb-8">
                    <h2 class="mb-2 text-2xl font-bold text-gray-900">S'inscrire comme bénévole</h2>
                    <p class="mb-6 text-gray-600">Les inscriptions se font via HelloAsso, c'est rapide et gratuit.</p>
                </div>

                <div class="max-w-2xl mx-auto">
                    <div class="mb-6 overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%);">
                            <h3 class="flex items-center gap-2 text-xl font-semibold text-white">
                                📋 Avant de cliquer…
                            </h3>
                        </div>
                        <div class="p-6 space-y-2 text-gray-700">
                            <p class="flex items-start gap-2">
                                <span class="text-[#1d3f89] font-bold"><i class="fa-solid fa-check"></i></span>
                                Assure-toi d'avoir ton binôme avec toi, vous allez vous inscrire ensemble
                            </p>
                            <p class="flex items-start gap-2">
                                <span class="text-[#1d3f89] font-bold"><i class="fa-solid fa-check"></i></span>
                                Choisissez votre soirée : vendredi 26 ou samedi 27 juin
                            </p>
                            <p class="flex items-start gap-2">
                                <span class="text-[#1d3f89] font-bold"><i class="fa-solid fa-check"></i></span>
                                Le tee-shirt est en option à 13,90 € (non obligatoire)
                            </p>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="https://www.helloasso.com/associations/calan-couleurs/evenements/formulaire-benevole-26-27-juin"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-block text-white font-semibold px-8 py-3 rounded-lg transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#8F1E98] shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                            style="background: linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%)">
                            Accéder au formulaire HelloAsso <i class="fa-solid fa-arrow-right fa-xs"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- JavaScript pour les onglets -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            function activateTab(targetTab) {
                // Réinitialiser tous les onglets
                tabButtons.forEach(btn => {
                    btn.classList.remove('tab-active', 'border-[#1d3f89]', 'text-[#1d3f89]');
                    btn.classList.add('border-transparent', 'text-gray-500');
                    btn.setAttribute('aria-selected', 'false');
                });

                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Activer le bon bouton
                const targetButton = document.querySelector('.tab-button[data-tab="' + targetTab + '"]');
                if (targetButton) {
                    targetButton.classList.add('tab-active', 'border-[#1d3f89]', 'text-[#1d3f89]');
                    targetButton.classList.remove('border-transparent', 'text-gray-500');
                    targetButton.setAttribute('aria-selected', 'true');
                }

                // Afficher le contenu correspondant
                const targetContent = document.getElementById('tab-' + targetTab);
                if (targetContent) {
                    targetContent.classList.remove('hidden');
                }
            }

            // Clic onglets
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    activateTab(targetTab);
                });
            });

            // Clic boutons "goto"
            document.querySelectorAll('.tab-button-goto').forEach(btn => {
                btn.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-goto');
                    activateTab(targetTab);
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>

@endsection
