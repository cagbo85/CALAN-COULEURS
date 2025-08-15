{{-- filepath: resources/views/auth/verify-email.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <title>Vérification d'email - Calan'Couleurs</title>
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

        <!-- Contenu principal -->
        <div class="w-full max-w-md p-8 bg-white rounded-xl shadow-2xl">

            <!-- Icône email -->
            <div class="text-center mb-6">
                <div class="mx-auto w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 3.26a2 2 0 001.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-purple-800 mb-2">
                    Vérifiez votre email
                </h2>
            </div>

            <!-- Message principal -->
            <div class="mb-6 text-center">
                <p class="text-gray-600 text-sm leading-relaxed">
                    Pour pouvoir continuer et accéder à votre espace d'administration,
                    vous devez d'abord vérifier votre adresse email.
                </p>

                <p class="text-gray-600 text-sm mt-3">
                    Nous vous invitions à cliquer sur le bouton ci-dessous pour vérifier votre adresse email :
                </p>

                <p class="font-semibold text-purple-800 mt-2 break-all">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <!-- Message de confirmation si email renvoyé -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-center">
                    <div class="flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-semibold">Email envoyé !</span>
                    </div>
                    <p class="text-sm">
                        Un nouveau lien de vérification a été envoyé à votre adresse email.
                    </p>
                </div>
            @endif

            <!-- Instructions -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Instructions
                </h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Vérifiez votre boîte de réception</li>
                    <li>• Cliquez sur le lien dans l'email</li>
                    <li>• Vous serez automatiquement connecté</li>
                </ul>
            </div>

            <!-- Actions -->
            <div class="space-y-4">
                <!-- Renvoyer l'email -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-purple-600 text-white py-3 px-4 rounded-lg hover:bg-purple-700 font-semibold transition duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        Renvoyer l'email de vérification
                    </button>
                </form>

                <!-- Déconnexion -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 font-medium transition duration-200">
                        Se déconnecter
                    </button>
                </form>
            </div>

            <!-- Aide -->
            <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                <p class="text-xs text-gray-500 mb-2">
                    Vous ne recevez pas l'email ?
                </p>
                <div class="text-xs text-gray-600 space-y-1">
                    <div>• Vérifiez vos spams/courriers indésirables</div>
                    <div>• Attendez quelques minutes</div>
                    <div>• Contactez l'administrateur si le problème persiste</div>
                </div>
            </div>

            <!-- Retour -->
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
