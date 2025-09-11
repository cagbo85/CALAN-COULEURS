<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>Dashboard - Calan'Couleurs</title> --}}
    <link rel="icon" type="image/png" href="/img/logos/TOUCAN.png">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @notifyCss
    <style>
        .notify {
            z-index: 999999 !important;
        }

        .connect {
            z-index: 999999 !important;
        }

        .emotify {
            z-index: 999999 !important;
        }

        .smiley {
            z-index: 999999 !important;
        }

        .toast {
            z-index: 999999 !important;
        }

        .relative [x-show="profileOpen"] {
            z-index: 50 !important;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <x-notify::notify />

    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- Logo -->
            <div class="flex items-center justify-center h-20 bg-gradient-to-r from-purple-600 to-pink-500">
                <a href="/">
                    <img src="/img/logos/LOGO/Logo-Calan.png" alt="Calan'Couleurs" class="h-12">
                </a>
            </div>

            <!-- Navigation -->
            <nav class="mt-8">
                <div class="px-4 mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu Principal</h3>
                </div>

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-6 py-3 {{ request()->routeIs('dashboard') ? 'text-gray-700 bg-purple-50 border-r-4 border-purple-500' : 'text-gray-600 hover:bg-gray-50 hover:text-purple-600 transition-colors' }}">
                    <i
                        class="fas fa-tachometer-alt mr-3 {{ request()->routeIs('dashboard') ? 'text-purple-500' : '' }}"></i>
                    <span class="{{ request()->routeIs('dashboard') ? 'font-medium' : '' }}">Administration</span>
                </a>

                <!-- Artistes -->
                <a href="{{ route('admin.artistes.index') }}"
                    class="flex items-center px-6 py-3 {{ request()->routeIs('admin.artistes.*') ? 'text-gray-700 bg-purple-50 border-r-4 border-purple-500' : 'text-gray-600 hover:bg-gray-50 hover:text-purple-600 transition-colors' }}">
                    <i
                        class="fas fa-microphone mr-3 {{ request()->routeIs('admin.artistes.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="{{ request()->routeIs('admin.artistes.*') ? 'font-medium' : '' }}">Artistes</span>
                    <span
                        class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">{{ App\Models\Artiste::count() }}</span>
                </a>

                <!-- Événements -->
                {{-- <a href="#"
                    class="flex items-center px-6 py-3 {{ request()->routeIs('admin.evenements.*') ? 'text-gray-700 bg-purple-50 border-r-4 border-purple-500' : 'text-gray-600 hover:bg-gray-50 hover:text-purple-600 transition-colors' }}">
                    <i
                        class="fas fa-calendar-alt mr-3 {{ request()->routeIs('admin.evenements.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="{{ request()->routeIs('admin.evenements.*') ? 'font-medium' : '' }}">Événements</span>
                    <span class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">12</span>
                </a> --}}

                <!-- Utilisateurs -->
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-6 py-3 {{ request()->routeIs('admin.users.*') ? 'text-gray-700 bg-purple-50 border-r-4 border-purple-500' : 'text-gray-600 hover:bg-gray-50 hover:text-purple-600 transition-colors' }}">
                    <i
                        class="fas fa-users mr-3 {{ request()->routeIs('admin.users.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="{{ request()->routeIs('admin.users.*') ? 'font-medium' : '' }}">Utilisateurs</span>
                    <span
                        class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">{{ App\Models\User::count() }}</span>
                </a>

                <!-- FAQS -->
                <a href="{{ route('admin.faqs.index') }}"
                    class="flex items-center px-6 py-3 {{ request()->routeIs('admin.faqs.*') ? 'text-gray-700 bg-purple-50 border-r-4 border-purple-500' : 'text-gray-600 hover:bg-gray-50 hover:text-purple-600 transition-colors' }}">
                    <i
                        class="fas fa-question-circle mr-3 {{ request()->routeIs('admin.faqs.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="{{ request()->routeIs('admin.faqs.*') ? 'font-medium' : '' }}">Foire aux
                        questions</span>
                    <span
                        class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">{{ App\Models\Faq::count() }}</span>
                </a>

                <!-- Contenu -->
                {{-- <a href="#"
                    class="flex items-center px-6 py-3 {{ request()->routeIs('admin.content.*') ? 'text-gray-700 bg-purple-50 border-r-4 border-purple-500' : 'text-gray-600 hover:bg-gray-50 hover:text-purple-600 transition-colors' }}">
                    <i
                        class="fas fa-file-alt mr-3 {{ request()->routeIs('admin.content.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="{{ request()->routeIs('admin.content.*') ? 'font-medium' : '' }}">Contenu</span>
                </a> --}}

                <!-- Médias -->
                {{-- <a href="#"
                    class="flex items-center px-6 py-3 {{ request()->routeIs('admin.media.*') ? 'text-gray-700 bg-purple-50 border-r-4 border-purple-500' : 'text-gray-600 hover:bg-gray-50 hover:text-purple-600 transition-colors' }}">
                    <i
                        class="fas fa-images mr-3 {{ request()->routeIs('admin.media.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="{{ request()->routeIs('admin.media.*') ? 'font-medium' : '' }}">Médias</span>
                </a> --}}

                {{-- <div class="px-4 mt-8 mb-4">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Système</h3>
                </div>

                <!-- Paramètres -->
                <a href="#"
                    class="flex items-center px-6 py-3 {{ request()->routeIs('admin.settings.*') ? 'text-gray-700 bg-purple-50 border-r-4 border-purple-500' : 'text-gray-600 hover:bg-gray-50 hover:text-purple-600 transition-colors' }}">
                    <i
                        class="fas fa-cog mr-3 {{ request()->routeIs('admin.settings.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="{{ request()->routeIs('admin.settings.*') ? 'font-medium' : '' }}">Paramètres</span>
                </a>

                <!-- Logs -->
                <a href="#"
                    class="flex items-center px-6 py-3 {{ request()->routeIs('admin.logs.*') ? 'text-gray-700 bg-purple-50 border-r-4 border-purple-500' : 'text-gray-600 hover:bg-gray-50 hover:text-purple-600 transition-colors' }}">
                    <i
                        class="fas fa-file-medical-alt mr-3 {{ request()->routeIs('admin.logs.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="{{ request()->routeIs('admin.logs.*') ? 'font-medium' : '' }}">Logs</span>
                </a> --}}
            </nav>

            <!-- User Info -->
            <div class="absolute bottom-0 w-full p-4 bg-gray-100 border-t">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr(auth()->user()->firstname, 0, 1) }}{{ substr(auth()->user()->lastname, 0, 1) }}
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->statut }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors"
                            title="Déconnexion">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Overlay mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">

            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden text-gray-500 hover:text-purple-600 transition-colors">
                            <i class="fas fa-bars text-xl"></i>
                        </button>

                        <div class="ml-4 lg:ml-0">
                            @if (request()->routeIs('dashboard'))
                                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                            @elseif(request()->routeIs('admin.artistes.index'))
                                <h1 class="text-2xl font-bold text-gray-900">Gestion des Artistes</h1>
                                <p class="text-sm text-gray-500">Gérez les artistes</p>
                            @elseif(request()->routeIs('admin.artistes.create'))
                                <h1 class="text-2xl font-bold text-gray-900">Gestion des Artistes</h1>
                                <p class="text-sm text-gray-500">Ajoutez un nouvel artiste
                                </p>
                            @elseif (request()->routeIs('admin.artistes.show'))
                                <h1 class="text-2xl font-bold text-gray-900">Gestion des Artistes</h1>
                                <p class="text-sm text-gray-500">Modifiez les informations de l'artiste</p>
                            @elseif (request()->routeIs('admin.faqs.index'))
                                <h1 class="text-2xl font-bold text-gray-900">Gestion des FAQs</h1>
                                <p class="text-sm text-gray-500">Gérez les questions fréquemment posées du festival</p>
                            @elseif (request()->routeIs('admin.faqs.show'))
                                <h1 class="text-2xl font-bold text-gray-900">Gestion des FAQs</h1>
                                <p class="text-sm text-gray-500">Modifiez les informations d'une question fréquente</p>
                            @elseif (request()->routeIs('admin.faqs.create'))
                                <h1 class="text-2xl font-bold text-gray-900">Gestion des FAQs</h1>
                                <p class="text-sm text-gray-500">Ajoutez une nouvelle question fréquente</p>
                            @elseif(request()->routeIs('admin.users.index'))
                                <h1 class="text-2xl font-bold text-gray-900">Gestion des Utilisateurs</h1>
                                <p class="text-sm text-gray-500">Gérez les utilisateurs</p>
                            @else
                                Dashboard
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        @if (request()->routeIs('admin.artistes.index'))
                            <!-- Page liste : Bouton ajouter -->
                            <a href="{{ route('admin.artistes.create') }}"
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center font-medium">
                                <i class="fas fa-plus mr-2"></i>
                                <span class="hidden sm:inline">Ajouter un artiste</span>
                                <span class="sm:hidden">Ajouter</span>
                            </a>
                        @elseif (request()->routeIs('admin.faqs.index'))
                            <!-- Page liste : Bouton ajouter -->
                            <a href="{{ route('admin.faqs.create') }}"
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center font-medium">
                                <i class="fas fa-plus mr-2"></i>
                                <span class="hidden sm:inline">Ajouter une FAQ</span>
                                <span class="sm:hidden">Ajouter</span>
                            </a>
                        @endif
                        <!-- Notifications -->
                        {{-- <button class="relative text-gray-500 hover:text-purple-600 transition-colors">
                            <i class="fas fa-bell text-xl"></i>
                            <span
                                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                        </button> --}}

                        <!-- Profile -->
                        <div class="relative" x-data="{ profileOpen: false }">
                            <button @click="profileOpen = !profileOpen"
                                class="flex items-center text-gray-700 hover:text-purple-600 transition-colors">
                                <div
                                    class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white font-bold mr-2">
                                    {{ substr(auth()->user()->firstname, 0, 1) }}
                                </div>
                                <span class="hidden md:block">{{ auth()->user()->firstname }}</span>
                                <i class="fas fa-chevron-down ml-1 text-sm"></i>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="profileOpen" @click.away="profileOpen = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 z-50">
                                {{-- <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-user mr-2"></i> Mon Profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-cog mr-2"></i> Paramètres
                                </a>
                                <hr class="my-1"> --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    @include('notify::components.notify')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Forcer la fermeture de toutes les notifications après 3 secondes
            setTimeout(function() {
                // Cacher toutes les notifications visibles
                document.querySelectorAll('.notify, .connect, .toast').forEach(function(notification) {
                    if (notification.style.display !== 'none') {
                        notification.style.display = 'none';
                    }
                });
            }, 5000);
        });
    </script>
    @notifyJs
</body>

</html>
