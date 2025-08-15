<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <title>Calan'Couleurs - Administration</title>
    <link rel="icon" type="image/png" href="/img/logos/TOUCAN.png">
</head>

<body class="min-h-screen"
    style="background: linear-gradient(135deg, rgba(39,42,199,0.9) 0%, rgba(143,30,152,0.9) 50%, rgba(255,15,99,0.9) 100%);">

    <div class="min-h-screen flex flex-col justify-center items-center p-6">
        <!-- Logo -->
        <div class="mb-8">
            <a href="/">
                <img src="/img/logos/LOGO/Logo-Calan-blanc.png" alt="Logo Calan'Couleurs" class="h-20 drop-shadow-lg">
            </a>
        </div>

        <!-- Titre -->
        <div class="mb-6 text-center">
            <h1 class="text-white text-3xl font-bold uppercase tracking-wide">
                Administration
            </h1>
        </div>

        <!-- Formulaire -->
        <div class="w-full max-w-md p-8 bg-white rounded-xl shadow-2xl">

            <h2 class="text-2xl font-bold text-purple-800 text-center mb-6">
                Connexion
            </h2>

            <!-- Messages d'erreur -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Login -->
                <div class="mb-4">
                    <label for="login" class="block text-sm font-medium text-gray-700 mb-2">
                        Email ou nom d'utilisateur
                    </label>
                    <input id="login" type="text" name="login" value="{{ old('login') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                        placeholder="Votre email ou login">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe
                    </label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                        placeholder="Votre mot de passe">
                </div>

                <!-- Remember -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2">
                        <span class="text-sm text-gray-700">Se souvenir de moi</span>
                    </label>
                </div>

                <!-- Liens d'aide -->
                <div class="mb-6 flex flex-col sm:flex-row justify-between items-center text-sm space-y-2 sm:space-y-0">
                    <a href="{{ route('password.request') }}"
                        class="text-purple-600 hover:text-purple-800 underline transition duration-200">
                        Mot de passe oublié ?
                    </a>
                    <a href="{{ route('auth.initialization-password') }}"
                        class="text-purple-600 hover:text-purple-800 underline transition duration-200">
                        Première connexion ?
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 font-semibold">
                    Se connecter
                </button>
            </form>

            <!-- Retour -->
            <div class="mt-6 text-center">
                <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-purple-600">
                    ← Retour au site
                </a>
            </div>
        </div>
    </div>
</body>

</html>
