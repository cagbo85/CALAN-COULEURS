@extends('layouts.admin')

<head>
    <title>Dashboard - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <!-- Total Artistes édition courante -->
                <div class="bg-white min-w-60 rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-microphone text-purple-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-500">Artistes</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $stats['artistes']['global']['total'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                <span class="text-green-600">{{ $stats['artistes']['edition_courante']['total'] }}
                                    en cours</span>
                                @if ($stats['artistes']['edition_courante']['actifs'] > 1)
                                    • <span class="text-green-600">{{ $stats['artistes']['edition_courante']['actifs'] }}
                                        actifs en cours</span>
                                @elseif ($stats['artistes']['edition_courante']['actifs'] == 1)
                                    • <span class="text-green-600">{{ $stats['artistes']['edition_courante']['actifs'] }}
                                        actif en cours</span>
                                @endif
                                @if ($stats['artistes']['edition_courante']['masques'] > 1)
                                    • <span class="text-orange-600">{{ $stats['artistes']['edition_courante']['masques'] }}
                                        masqués en cours</span>
                                @elseif ($stats['artistes']['edition_courante']['masques'] == 1)
                                    • <span class="text-orange-600">{{ $stats['artistes']['edition_courante']['masques'] }}
                                        masqué en cours</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total Utilisateurs -->
                <div class="bg-white min-w-60 rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-users text-blue-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-500">Utilisateurs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['users']['total'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                @if ($stats['users']['verified'] > 1)
                                    <span class="text-green-600">{{ $stats['users']['verified'] }} vérifiés</span>
                                @elseif ($stats['users']['verified'] == 1)
                                    <span class="text-green-600">{{ $stats['users']['verified'] }} vérifié</span>
                                @endif
                                @if ($stats['users']['unverified'] > 1)
                                    • <span class="text-orange-600">{{ $stats['users']['unverified'] }} non vérifiés</span>
                                @elseif ($stats['users']['unverified'] == 1)
                                    • <span class="text-orange-600">{{ $stats['users']['unverified'] }} non vérifié</span>
                                @endif
                                • <span class="text-green-600">{{ $stats['users']['actifs'] }} actifs</span>
                                @if ($stats['users']['desactives'] > 1)
                                    • <span class="text-red-600">{{ $stats['users']['desactives'] }} désactivés</span>
                                @elseif ($stats['users']['desactives'] == 1)
                                    • <span class="text-red-600">{{ $stats['users']['desactives'] }} désactivé</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total FAQs -->
                <div class="bg-white min-w-60 rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-circle-question text-green-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-500">FAQs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['faqs']['total'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                @if ($stats['faqs']['actives'] > 1)
                                    <span class="text-green-600">{{ $stats['faqs']['actives'] }} publiées</span>
                                @elseif ($stats['faqs']['actives'] == 1)
                                    <span class="text-green-600">{{ $stats['faqs']['actives'] }} publiée</span>
                                @endif
                                @if ($stats['faqs']['masquees'] > 1)
                                    • <span class="text-orange-600">{{ $stats['faqs']['masquees'] }} brouillons</span>
                                @elseif ($stats['faqs']['masquees'] == 1)
                                    • <span class="text-orange-600">{{ $stats['faqs']['masquees'] }} brouillon</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total éditions -->
                <div class="bg-white min-w-60 rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-calendar-days text-yellow-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-500">Éditions</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['editions']['total'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                @if ($stats['editions']['actives'] > 1)
                                    <span class="text-green-600">{{ $stats['editions']['actives'] }} actives</span>
                                @elseif ($stats['editions']['actives'] == 1)
                                    <span class="text-green-600">{{ $stats['editions']['actives'] }} active</span>
                                @endif
                                @if ($stats['editions']['draft'] > 1)
                                    • <span class="text-orange-600">{{ $stats['editions']['draft'] }} à venir</span>
                                @elseif ($stats['editions']['draft'] == 1)
                                    • <span class="text-orange-600">{{ $stats['editions']['draft'] }} à venir</span>
                                @endif
                                @if ($stats['editions']['inactives'] > 1)
                                    • <span class="text-red-600">{{ $stats['editions']['inactives'] }} terminées</span>
                                @elseif ($stats['editions']['inactives'] == 1)
                                    • <span class="text-red-600">{{ $stats['editions']['inactives'] }} terminée</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides & activité récente -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Actions Rapides -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Actions Rapides</h3>
                    </div>
                    <div class="p-6 space-y-4">

                        <a href="{{ route('admin.artistes.create') }}"
                            class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <i class="fa-solid fa-microphone text-purple-600 text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-gray-900">Nouvel(le) Artiste</p>
                                <p class="text-sm text-gray-500">Ajouter un(e) nouvel(le) artiste</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.faqs.create') }}"
                            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <i class="fa-solid fa-circle-question text-green-600 text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-gray-900">Nouvelle FAQ</p>
                                <p class="text-sm text-gray-500">Ajouter une nouvelle question fréquente</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.editions.create') }}"
                            class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                            <i class="fa-solid fa-calendar-days text-yellow-600 text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-gray-900">Nouvelle Édition</p>
                                <p class="text-sm text-gray-500">Ajouter une nouvelle édition</p>
                            </div>
                        </a>

                        {{-- <a href="#"
                            class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <i class="fa-solid fa-circle-plus text-purple-600 text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-gray-900">Nouvel Événement</p>
                                <p class="text-sm text-gray-500">Créer un nouvel événement</p>
                            </div>
                        </a> --}}

                        {{-- <a href="#"
                            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <i class="fa-solid fa-user-plus text-blue-600 text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-gray-900">Nouvel Utilisateur</p>
                                <p class="text-sm text-gray-500">Ajouter un membre de l'équipe</p>
                            </div>
                        </a>

                        <a href="#"
                            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <i class="fa-solid fa-pen-to-square text-green-600 text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-gray-900">Nouvelle Page</p>
                                <p class="text-sm text-gray-500">Créer du contenu</p>
                            </div>
                        </a> --}}
                    </div>
                </div>

                <!-- Activité Récente -->
                {{-- <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Activité Récente</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">
                                        <span class="font-medium">Charles Agbo</span> a créé un nouvel
                                        événement
                                    </p>
                                    <p class="text-xs text-gray-500">Il y a 2 heures</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">
                                        Nouveau membre inscrit : <span class="font-medium">Marie Dubois</span>
                                    </p>
                                    <p class="text-xs text-gray-500">Il y a 4 heures</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 mr-3"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">
                                        Page "À propos" mise à jour
                                    </p>
                                    <p class="text-xs text-gray-500">Hier</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                                Voir toute l'activité →
                            </a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </main>
@endsection
