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
                <img src="/img/logos/LOGO/Logo-Calan-blanc.png" alt="" aria-hidden="true" class="h-20 drop-shadow-lg">
            </a>
        </div>

        <!-- Titre -->
        <div class="mb-6 text-center">
            <h1 class="text-white text-3xl font-bold uppercase tracking-wide">
                Administration
            </h1>
        </div>

        <!-- Formulaire -->
        <div class="w-full max-w-lg p-8 bg-white rounded-xl shadow-2xl">

            <!-- Titre du formulaire -->
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-purple-800 mb-2">
                    Première connexion ?
                </h2>
                <p class="text-gray-600 text-sm">
                    Veuillez renseigner les informations suivantes pour initialiser votre compte
                </p>
            </div>

            <!-- Messages d'erreur -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Messages de statut -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.initialize') }}" class="space-y-4">
                @csrf

                <!-- Login/Username -->
                <div>
                    <label for="login" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom d'utilisateur <span class="text-red-500">*</span>
                    </label>
                    <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('login') border-red-500 @enderror"
                        placeholder="Votre nom d'utilisateur">
                    @error('login')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse e-mail <span class="text-red-500">*</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('email') border-red-500 @enderror"
                        placeholder="votre@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statut dans l'association -->
                <!-- Statut dans l'association -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                        Statut dans l'association <span class="text-red-500">*</span>
                    </label>
                    <input id="statut" type="text" name="statut" value="{{ old('statut') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('statut') border-red-500 @enderror"
                        placeholder="Votre fonction dans l'association">

                    <!-- Aide discrète -->
                    <p class="mt-1 text-xs text-gray-500">
                        <span class="font-medium">Exemples :</span>
                        Président • Trésorier • Secrétaire • Responsable Communication • Bénévole • Membre actif...
                    </p>

                    @error('statut')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe <span class="text-red-500">*</span>
                    </label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('password') border-red-500 @enderror"
                        placeholder="Choisissez un mot de passe sécurisé">
                    <div class="mt-1 text-xs text-gray-500">
                        <div>• Au moins 8 caractères</div>
                        <div>• Au moins une majuscule et une minuscule</div>
                        <div>• Au moins un chiffre</div>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmation mot de passe -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmer le mot de passe <span class="text-red-500">*</span>
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 @error('password_confirmation') border-red-500 @enderror"
                        placeholder="Confirmez votre mot de passe">
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Information importante -->
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-blue-800 text-sm">
                            <p class="font-semibold mb-1">Important :</p>
                            <p>Votre compte sera créé dans un premier temps avec des droits d'accès limités.
                                L'administrateur validera votre compte en vous attribuant les droits appropriés avant
                                que vous puissiez accéder à toutes
                                les fonctionnalités.</p>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-purple-600 text-white py-3 px-4 rounded-md hover:bg-purple-700 font-semibold transition duration-200">
                        Initialiser mon compte
                    </button>
                </div>
            </form>

            <!-- Lien retour -->
            <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600 mb-2">Vous avez déjà un compte ?</p>
                <a href="{{ route('login') }}"
                    class="text-purple-600 hover:text-purple-800 underline transition duration-200 font-medium">
                    Se connecter
                </a>
            </div>

            <!-- Retour accueil -->
            <div class="mt-4 text-center">
                <a href="{{ url('/') }}"
                    class="text-sm text-gray-600 hover:text-purple-600 transition duration-200">
                    ← Retour au site
                </a>
            </div>
        </div>
    </div>
</body>

</html>
