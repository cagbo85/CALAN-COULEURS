@extends('layouts.admin')

<head>
    <title>Dashboard - Calan'Couleurs</title>
</head>

@section('content')
    <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="p-6">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

                <!-- Total Artistes -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-microphone-alt text-purple-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-500">Artistes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['artistes']['total'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                <span class="text-green-600">{{ $stats['artistes']['actifs'] }} actifs</span>
                                @if ($stats['artistes']['masques'] > 0)
                                    • <span class="text-orange-600">{{ $stats['artistes']['masques'] }} masqués</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total Utilisateurs -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-500">Utilisateurs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['users']['total'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                <span class="text-green-600">{{ $stats['users']['verified'] }} vérifiés</span>
                                @if ($stats['users']['unverified'] > 0)
                                    • <span class="text-orange-600">{{ $stats['users']['unverified'] }} non vérifiés</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total FAQs -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-question-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-500">FAQs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['faqs']['total'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                <span class="text-green-600">{{ $stats['faqs']['actives'] }} publiées</span>
                                @if ($stats['faqs']['masquees'] > 0)
                                    • <span class="text-orange-600">{{ $stats['faqs']['masquees'] }} brouillons</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Actions Rapides -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Actions Rapides</h3>
                    </div>
                    <div class="p-6 space-y-4">

                        <a href="{{ route('admin.artistes.create') }}"
                            class="flex items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                            <i class="fas fa-microphone-alt text-orange-600 text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-gray-900">Nouvel Artiste</p>
                                <p class="text-sm text-gray-500">Ajouter un(e) nouvel(le) artiste</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.faqs.create') }}"
                            class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <i class="fas fa-question-circle text-purple-600 text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-gray-900">Nouvelle FAQ</p>
                                <p class="text-sm text-gray-500">Ajouter une nouvelle question fréquente</p>
                            </div>
                        </a>

                        {{-- <a href="#"
                            class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <i class="fas fa-plus-circle text-purple-600 text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-gray-900">Nouvel Événement</p>
                                <p class="text-sm text-gray-500">Créer un nouvel événement</p>
                            </div>
                        </a> --}}

                        {{-- <a href="#"
                            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <i class="fas fa-user-plus text-blue-600 text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-gray-900">Nouvel Utilisateur</p>
                                <p class="text-sm text-gray-500">Ajouter un membre de l'équipe</p>
                            </div>
                        </a>

                        <a href="#"
                            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <i class="fas fa-edit text-green-600 text-xl mr-4"></i>
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
