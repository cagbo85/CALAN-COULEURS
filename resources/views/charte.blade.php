@extends('layouts.app')

@section('title', 'Charte du festivalier - Calan\'Couleurs Festival 2025')

@section('content')
    <main class="w-full">
        <section class="text-white py-16 px-6" style="background: linear-gradient(135deg, #8F1E98 0%, #FF0F63 100%);">
            <div class="container mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Charte du festivalier
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-90">
                    Ensemble, faisons de Calan'Couleurs un moment inoubliable !
                </p>
                <div class="text-6xl animate-bounce">🎉</div>
            </div>
        </section>

        {{-- Objets autorisés/interdits --}}
        <section class="py-16 px-6 bg-white">
            <div class="container mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-[#8F1E98] mb-4">
                        Infos pratiques • Objets autorisés & interdits
                    </h2>
                    <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                        Pour que tout se passe au mieux, voici la liste des objets que vous pouvez ✅ (et ne pouvez pas ⛔️)
                        apporter sur le site.
                        <br><strong>Merci de respecter ces consignes pour assurer la sécurité et le confort de tous !
                            🙌</strong>
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-12 max-w-6xl mx-auto">
                    {{-- Objets autorisés --}}
                    <div class="bg-green-50 rounded-2xl p-8 border-4 border-green-200">
                        <div class="text-center mb-6">
                            <div class="text-6xl mb-4">✅</div>
                            <h3 class="text-2xl font-bold text-green-700">Objets autorisés</h3>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-center text-green-800">
                                <span class="text-2xl mr-3">☂️</span>
                                <span>Parapluie</span>
                            </li>
                            <li class="flex items-center text-green-800">
                                <span class="text-2xl mr-3">📱</span>
                                <span>Téléphone & batterie externe</span>
                            </li>
                            <li class="flex items-center text-green-800">
                                <span class="text-2xl mr-3">📸</span>
                                <span>Petit appareil photo</span>
                            </li>
                            <li class="flex items-center text-green-800">
                                <span class="text-2xl mr-3">🧴</span>
                                <span>Crème solaire (&lt;30cl)</span>
                            </li>
                            <li class="flex items-center text-green-800">
                                <span class="text-2xl mr-3">🧢</span>
                                <span>Casquettes & chapeau</span>
                            </li>
                            <li class="flex items-center text-green-800">
                                <span class="text-2xl mr-3">🔥</span>
                                <span>Briquet</span>
                            </li>
                            <li class="flex items-center text-green-800">
                                <span class="text-2xl mr-3">💨</span>
                                <span>Cigarette électronique</span>
                            </li>
                            <li class="flex items-center text-green-800">
                                <span class="text-2xl mr-3">🎒</span>
                                <span>Petit sac & banane</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Objets interdits --}}
                    <div class="bg-red-50 rounded-2xl p-8 border-4 border-red-200">
                        <div class="text-center mb-6">
                            <div class="text-6xl mb-4">⛔️</div>
                            <h3 class="text-2xl font-bold text-red-700">Objets interdits</h3>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-center text-red-800">
                                <span class="text-2xl mr-3">🔪</span>
                                <span>Objets tranchants ou dangereux</span>
                            </li>
                            <li class="flex items-center text-red-800">
                                <span class="text-2xl mr-3">🍕</span>
                                <span>Nourriture (food trucks à l'intérieur !)</span>
                            </li>
                            <li class="flex items-center text-red-800">
                                <span class="text-2xl mr-3">🛴</span>
                                <span>Trottinette, vélo, skate</span>
                            </li>
                            <li class="flex items-center text-red-800">
                                <span class="text-2xl mr-3">💨</span>
                                <span>Produits inflammables (aérosol, gaz)</span>
                            </li>
                            <li class="flex items-center text-red-800">
                                <span class="text-2xl mr-3">🧳</span>
                                <span>Gros sacs ou valise</span>
                            </li>
                            <li class="flex items-center text-red-800">
                                <span class="text-2xl mr-3">🐕</span>
                                <span>Animaux (sauf chiens guides)</span>
                            </li>
                            <li class="flex items-center text-red-800">
                                <span class="text-2xl mr-3">🚫</span>
                                <span>Substances illicites</span>
                            </li>
                            <li class="flex items-center text-red-800">
                                <span class="text-2xl mr-3">🍺</span>
                                <span>Alcool (bar à l'intérieur !)</span>
                            </li>
                            <li class="flex items-center text-red-800">
                                <span class="text-2xl mr-3">🍼</span>
                                <span>Bouteilles en verre</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- Sections éthiques --}}
        <section class="py-16 px-6 bg-gray-50">
            <div class="container mx-auto">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

                    {{-- Consentement --}}
                    <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow">
                        <div class="text-6xl mb-4">🤝</div>
                        <h3 class="text-xl font-bold text-[#8F1E98] mb-4">LE CONSENTEMENT : PARLONS-EN !</h3>
                        <p class="text-gray-700 text-sm leading-relaxed">
                            Le respect mutuel est la base d'un festival réussi. Chaque personne a le droit de se sentir en
                            sécurité.
                            <br><br>
                            <strong>Non, c'est non !</strong> Respectons les limites de chacun et créons ensemble un espace
                            bienveillant.
                        </p>
                    </div>

                    {{-- Consommation modérée --}}
                    <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow">
                        <div class="text-6xl mb-4">🍻</div>
                        <h3 class="text-xl font-bold text-[#8F1E98] mb-4">CONSOMMONS AVEC MODÉRATION</h3>
                        <p class="text-gray-700 text-sm leading-relaxed">
                            L'alcool peut être sympa, mais gardons la tête froide ! Hydratez-vous régulièrement et
                            surveillez vos proches.
                            <br><br>
                            <strong>Profitez de la musique, pas des excès.</strong> Des stands d'eau gratuits sont
                            disponibles !
                        </p>
                    </div>

                    {{-- Respect --}}
                    <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow">
                        <div class="text-6xl mb-4">💜</div>
                        <h3 class="text-xl font-bold text-[#8F1E98] mb-4">RESTONS RESPECTUEUX</h3>
                        <p class="text-gray-700 text-sm leading-relaxed">
                            Calan'Couleurs, c'est un festival inclusif et bienveillant. Respectons les artistes, les
                            bénévoles et les autres festivaliers.
                            <br><br>
                            <strong>Zéro tolérance</strong> pour le harcèlement, le racisme ou toute forme de
                            discrimination.
                        </p>
                    </div>

                    {{-- Camping propre --}}
                    <div class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow">
                        <div class="text-6xl mb-4">🏕️</div>
                        <h3 class="text-xl font-bold text-[#8F1E98] mb-4">CAMPONS PROPREMENT</h3>
                        <p class="text-gray-700 text-sm leading-relaxed">
                            Le camping, c'est génial ! Mais restons propres : utilisez les poubelles et les sanitaires
                            prévus.
                            <br><br>
                            <strong>Laissons le site encore plus beau qu'on l'a trouvé</strong> pour les générations futures
                            ! 🌱
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-16 px-6 text-white" style="background: linear-gradient(135deg, #8F1E98 0%, #FF0F63 100%);">
            <div class="container mx-auto text-center">
                <h2 class="text-3xl font-bold mb-6">Prêt·e à vivre Calan'Couleurs ? 🎪</h2>
                <p class="text-xl mb-8 opacity-90">
                    En respectant cette charte, tu contribues à faire de ce festival un moment magique pour tous !
                </p>
            </div>
        </section>
    </main>
@endsection
