@extends('layouts.app')

@section('title', 'Charte du festivalier - Calan\'Couleurs Festival ' . $currentEdition->year)

@section('content')
    <div class="w-full min-h-screen px-4 py-12 pt-8 sm:px-6 lg:px-8 bg-[#EEF1FF]">

        <div class="mx-auto mb-12 max-w-7xl">
            <div class="mb-8 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-[#272AC7] mb-4">
                    Charte du festivalier
                </h1>
                <p class="max-w-3xl mx-auto text-lg text-gray-600">
                    Ensemble, faisons de Calan'Couleurs un moment inoubliable, respectueux et festif.
                    Voici les règles simples pour profiter pleinement du festival en toute sérénité.
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-4 mb-8">
                <div class="px-6 py-3 bg-white border border-[#272AC7]/15 rounded-lg shadow-sm">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">🤝</span>
                        <span class="font-medium text-gray-600">Respect</span>
                    </div>
                </div>
                <div class="px-6 py-3 bg-white border border-[#272AC7]/15 rounded-lg shadow-sm">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">🍻</span>
                        <span class="font-medium text-gray-600">Modération</span>
                    </div>
                </div>
                <div class="px-6 py-3 bg-white border border-[#272AC7]/15 rounded-lg shadow-sm">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">🏕️</span>
                        <span class="font-medium text-gray-600">Camping propre</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Objets autorisés/interdits --}}
        <div class="mx-auto mb-12 max-w-7xl">
            <div class="grid gap-8 md:grid-cols-2">
                {{-- Objets autorisés --}}
                <div class="p-8 border-4 border-green-200 bg-green-50 rounded-2xl">
                    <div class="mb-6 text-center">
                        <div class="mb-4 text-6xl">✅</div>
                        <h3 class="text-2xl font-bold text-green-700">Objets autorisés</h3>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-center text-green-800">
                            <span class="mr-3 text-2xl">☂️</span>
                            <span>Parapluie</span>
                        </li>
                        <li class="flex items-center text-green-800">
                            <span class="mr-3 text-2xl">📱</span>
                            <span>Téléphone & batterie externe</span>
                        </li>
                        <li class="flex items-center text-green-800">
                            <span class="mr-3 text-2xl">📸</span>
                            <span>Petit appareil photo</span>
                        </li>
                        <li class="flex items-center text-green-800">
                            <span class="mr-3 text-2xl">🧴</span>
                            <span>Crème solaire (&lt;30cl)</span>
                        </li>
                        <li class="flex items-center text-green-800">
                            <span class="mr-3 text-2xl">🧢</span>
                            <span>Casquettes & chapeau</span>
                        </li>
                        <li class="flex items-center text-green-800">
                            <span class="mr-3 text-2xl">🔥</span>
                            <span>Briquet</span>
                        </li>
                        <li class="flex items-center text-green-800">
                            <span class="mr-3 text-2xl">💨</span>
                            <span>Cigarette électronique</span>
                        </li>
                        <li class="flex items-center text-green-800">
                            <span class="mr-3 text-2xl">🎒</span>
                            <span>Petit sac & banane</span>
                        </li>
                    </ul>
                </div>

                {{-- Objets interdits --}}
                <div class="p-8 border-4 border-red-200 bg-red-50 rounded-2xl">
                    <div class="mb-6 text-center">
                        <div class="mb-4 text-6xl">⛔️</div>
                        <h3 class="text-2xl font-bold text-red-700">Objets interdits</h3>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-center text-red-800">
                            <span class="mr-3 text-2xl">🔪</span>
                            <span>Objets tranchants ou dangereux</span>
                        </li>
                        <li class="flex items-center text-red-800">
                            <span class="mr-3 text-2xl">🍕</span>
                            <span>Nourriture (food trucks à l'intérieur !)</span>
                        </li>
                        <li class="flex items-center text-red-800">
                            <span class="mr-3 text-2xl">🛴</span>
                            <span>Trottinette, vélo, skate</span>
                        </li>
                        <li class="flex items-center text-red-800">
                            <span class="mr-3 text-2xl">💨</span>
                            <span>Produits inflammables (aérosol, gaz)</span>
                        </li>
                        <li class="flex items-center text-red-800">
                            <span class="mr-3 text-2xl">🧳</span>
                            <span>Gros sacs ou valise</span>
                        </li>
                        <li class="flex items-center text-red-800">
                            <span class="mr-3 text-2xl">🐕</span>
                            <span>Animaux (sauf chiens guides)</span>
                        </li>
                        <li class="flex items-center text-red-800">
                            <span class="mr-3 text-2xl">🚫</span>
                            <span>Substances illicites</span>
                        </li>
                        <li class="flex items-center text-red-800">
                            <span class="mr-3 text-2xl">🍺</span>
                            <span>Alcool (bar à l'intérieur !)</span>
                        </li>
                        <li class="flex items-center text-red-800">
                            <span class="mr-3 text-2xl">🍼</span>
                            <span>Bouteilles en verre</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Règles de vie --}}
        <div class="mx-auto mb-12 max-w-7xl">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold text-[#272AC7] mb-4">
                    Les valeurs du festival
                </h2>
                <p class="max-w-3xl mx-auto text-lg text-gray-600">
                    Calan'Couleurs est un lieu de fête, mais aussi un espace de respect, de bienveillance et de partage.
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">

                <div
                    class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-[#272AC7]/10">
                    <div class="mb-4 text-6xl">🤝</div>
                    <h3 class="text-xl font-bold text-[#272AC7] mb-4">Le consentement</h3>
                    <p class="text-sm leading-relaxed text-gray-700">
                        Le respect mutuel est la base d’un festival réussi. Chacun doit se sentir libre et en sécurité.
                        Non, c’est non.
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-[#272AC7]/10">
                    <div class="mb-4 text-6xl">🍻</div>
                    <h3 class="text-xl font-bold text-[#272AC7] mb-4">La modération</h3>
                    <p class="text-sm leading-relaxed text-gray-700">
                        L’alcool peut faire partie de la fête, mais toujours avec modération. Pensez à boire de l’eau et à
                        prendre soin de vos proches.
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-[#272AC7]/10">
                    <div class="mb-4 text-6xl">💜</div>
                    <h3 class="text-xl font-bold text-[#272AC7] mb-4">Le respect</h3>
                    <p class="text-sm leading-relaxed text-gray-700">
                        Respectons les artistes, les bénévoles, les équipes et les autres festivaliers. Le festival vit
                        grâce à la bienveillance de chacun.
                    </p>
                </div>

                <div
                    class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow border border-[#272AC7]/10">
                    <div class="mb-4 text-6xl">🏕️</div>
                    <h3 class="text-xl font-bold text-[#272AC7] mb-4">Le camping propre</h3>
                    <p class="text-sm leading-relaxed text-gray-700">
                        Utilisez les poubelles et les sanitaires prévus. Laissons le site propre et agréable pour tout le
                        monde.
                    </p>
                </div>

            </div>
        </div>

        <section class="px-6 pb-4 text-white">
            <div class="container mx-auto text-center">
                <h2 class="mb-6 text-3xl font-bold text-[#272AC7]">Prêt·e à vivre Calan'Couleurs ? 🎪</h2>
                <p class="max-w-3xl mx-auto text-lg text-gray-600">
                    En respectant cette charte, tu contribues à faire de ce festival un moment magique pour tous.
                </p>
            </div>
        </section>
    </div>
@endsection
