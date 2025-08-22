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
                <img src="/img/logos/LOGO/Logo-Calan-blanc.png" alt="" aria-hidden="true" class="h-20 drop-shadow-lg">
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

            <!-- Icône de succès -->
            <div class="text-center mb-6">
                <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-purple-800 mb-2">
                    🎉 Compte initialisé !
                </h2>
            </div>

            <!-- Message de confirmation -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-center">
                    <div class="flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-semibold">Succès !</span>
                    </div>
                    <p class="text-sm">
                        {{ session('status') }}
                    </p>
                </div>
            @endif

            <!-- Message principal -->
            <div class="mb-6 text-center">
                <p class="text-gray-700 text-base leading-relaxed mb-4">
                    <strong>Félicitations !</strong> Votre compte a été initialisé avec succès.
                </p>

                <p class="text-gray-600 text-sm leading-relaxed">
                    Pour finaliser l'activation de votre compte et accéder à votre espace d'administration,
                    vous devez maintenant <strong>vérifier votre adresse email</strong>.
                </p>
            </div>

            <!-- Instructions détaillées -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 3.26a2 2 0 001.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    Étapes suivantes :
                </h3>
                <ol class="text-sm text-blue-700 space-y-2">
                    <li class="flex items-start">
                        <span
                            class="flex-shrink-0 w-5 h-5 bg-blue-600 text-white rounded-full text-xs flex items-center justify-center mr-3 mt-0.5">1</span>
                        <span>Consultez votre boîte de réception email</span>
                    </li>
                    <li class="flex items-start">
                        <span
                            class="flex-shrink-0 w-5 h-5 bg-blue-600 text-white rounded-full text-xs flex items-center justify-center mr-3 mt-0.5">2</span>
                        <span>Cliquez sur le lien de vérification dans l'email</span>
                    </li>
                    <li class="flex items-start">
                        <span
                            class="flex-shrink-0 w-5 h-5 bg-blue-600 text-white rounded-full text-xs flex items-center justify-center mr-3 mt-0.5">3</span>
                        <span>Vous serez automatiquement connecté à votre espace</span>
                    </li>
                </ol>
            </div>

            <!-- Aide -->
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <h4 class="font-semibold text-yellow-800 mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Vous ne recevez pas l'email ?
                </h4>
                <div class="text-xs text-yellow-700 space-y-1">
                    <div>• Vérifiez votre dossier spam/courriers indésirables</div>
                    <div>• Attendez quelques minutes (parfois il y a du délai)</div>
                    <div>• Vérifiez que l'adresse email est correcte</div>
                    <div>• Contactez un administrateur si le problème persiste</div>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <!-- Bouton retour connexion -->
                <a href="{{ route('login') }}"
                    class="w-full block bg-purple-600 text-white py-3 px-4 rounded-lg hover:bg-purple-700 font-semibold transition duration-200 text-center">
                    Retour à la connexion
                </a>

                <!-- Lien d'aide -->
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-2">Besoin d'aide ?</p>
                    <a href="mailto:admin@calan-couleurs.fr"
                        class="text-purple-600 hover:text-purple-800 underline text-sm transition duration-200">
                        Contacter l'administration
                    </a>
                </div>
            </div>

            <!-- Retour accueil -->
            <div class="mt-6 pt-4 border-t border-gray-200 text-center">
                <a href="{{ url('/') }}"
                    class="text-sm text-gray-600 hover:text-purple-600 transition duration-200 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour au site
                </a>
            </div>
        </div>
    </div>
</body>

</html>
