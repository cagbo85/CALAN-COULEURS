<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/png" href="{{ asset('img/logos/TOUCAN.png') }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calan'Couleurs - Contact</title>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'urbanist': ['Urbanist', 'sans-serif'],
                        'urbanist-bold': ['Urbanist Bold', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx', 'resources/js/navbar-loader.jsx'])

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="w-full">
    <header class="sticky top-0 z-10 bg-white">
        <div id="navbar-root" data-home-url="{{ url('/') }}" data-programmation-url="{{ url('/programmation') }}"
            data-festival-url="{{ url('/notre-histoire') }}" data-contact-url="{{ url('/contact') }}"
            data-billetterie-url="https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs">
        </div>
    </header>

    <main class="w-full">
        <!-- Bannière -->
        <section class="w-full h-[300px] bg-cover bg-center bg-no-repeat flex items-center justify-center"
            style="background-image: linear-gradient(rgba(143, 30, 152, 0.7), rgba(255, 15, 99, 0.7)), url('/img/logos/accueil_public.png')">
            <div class="text-center px-4">
                <h1 class="text-4xl sm:text-5xl font-bold text-white drop-shadow-lg mb-4">
                    Contactez-nous
                </h1>
            </div>
        </section>

        <!-- Contenu -->
        <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
            <div class="container mx-auto max-w-3xl">
                <div class="p-8 rounded-lg shadow-md"
                    style="background: linear-gradient(180deg, rgba(255,15,99,0.2), rgba(143,30,152,0.2), rgba(39,42,199,0.2));">
                    <h2 class="text-3xl font-bold text-[#8F1E98] mb-8 text-center">Restons en contact</h2>

                    <div class="space-y-12">
                        <!-- Email -->
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <div class="flex items-center justify-center w-16 h-16 bg-[#FF0F63]/10 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#FF0F63]" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="text-center md:text-left">
                                <h3 class="text-xl font-semibold text-[#8F1E98] mb-2">Par email</h3>
                                <p class="text-gray-600 mb-3">Pour toute question ou demande d'information :</p>
                                <a href="mailto:calancouleurs@gmail.com"
                                    class="text-[#FF0F63] hover:text-[#8F1E98] text-xl font-bold transition-colors duration-300">
                                    calancouleurs@gmail.com
                                </a>
                            </div>
                        </div>

                        <!-- Téléphone -->
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <div class="flex items-center justify-center w-16 h-16 bg-[#8F1E98]/10 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#8F1E98]" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div class="text-center md:text-left">
                                <h3 class="text-xl font-semibold text-[#8F1E98] mb-2">Par téléphone</h3>
                                <p class="text-gray-600 mb-3">Pour nous joindre directement :</p>

                                <div class="space-y-2 md:space-y-3">
                                    <a href="tel:+33782422959"
                                        class="text-[#FF0F63] hover:text-[#8F1E98] text-xl font-bold transition-colors duration-300 block">
                                        07 82 42 29 59
                                    </a>
                                    <a href="tel:+33782741747"
                                        class="text-[#FF0F63] hover:text-[#8F1E98] text-xl font-bold transition-colors duration-300 block">
                                        07 82 74 17 47
                                    </a>
                                </div>

                                <p class="text-sm text-gray-600 mt-3 italic">
                                    Ces contacts sont strictement réservés aux demandes concernant le festival.
                                </p>
                            </div>
                        </div>

                        <!-- Réseaux sociaux -->
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <div class="flex items-center justify-center w-16 h-16 bg-[#FF0F63]/10 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#FF0F63]" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="text-center md:text-left">
                                <h3 class="text-xl font-semibold text-[#8F1E98] mb-2">Réseaux sociaux</h3>
                                <p class="text-gray-600 mb-3">Suivez-nous pour ne rien manquer :</p>
                                <div class="flex space-x-4 justify-center md:justify-start">
                                    <a href="https://www.instagram.com/calancouleurs/" target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-[#FF0F63] hover:text-[#8F1E98] transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" class="w-8 h-8" viewBox="0 0 16 16">
                                            <path
                                                d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                                        </svg>
                                    </a>
                                    <a href="https://www.facebook.com/profile.php?id=61555539331779" target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-[#FF0F63] hover:text-[#8F1E98] transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" class="w-8 h-8" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-[#8F1E98] text-white py-12">
        <div class="container mx-auto px-6">
            {{-- Section supérieure avec logo et navigation --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                {{-- Logo --}}
                <div class="mb-6 md:mb-0">
                    <a href="/">
                        <img src="/img/logos/LOGO/Logo-Calan-blanc.png" alt="Logo Calan'Couleurs" class="h-16">
                    </a>
                </div>

                {{-- Navigation --}}
                <nav class="flex flex-col sm:flex-row gap-3 sm:gap-8 text-center sm:text-left">
                    <a href="/"
                        class="text-white hover:text-[#FF0F63] font-medium transition duration-300">Accueil</a>
                    <a href="{{ route('festival') }}"
                        class="text-white hover:text-[#FF0F63] font-medium transition duration-300">Le Festival</a>
                    <a href="{{ route('programmation') }}"
                        class="text-white hover:text-[#FF0F63] font-medium transition duration-300">Programmation</a>
                    <a href="{{ route('contact') }}"
                        class="text-white hover:text-[#FF0F63] font-medium transition duration-300">Contact</a>
                    <a href="https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs"
                        target="_blank" rel="noopener noreferrer"
                        class="text-white hover:text-[#FF0F63] font-medium transition duration-300">Billetterie</a>
                </nav>
            </div>

            {{-- Ligne séparatrice --}}
            <hr class="border-white/20 my-8">

            {{-- Section inférieure avec réseaux sociaux et mentions légales --}}
            <div class="flex flex-col md:flex-row justify-between items-center">
                {{-- Réseaux sociaux --}}
                <div class="flex space-x-6 mb-6 md:mb-0">
                    <a href="https://www.instagram.com/calancouleurs/" target="_blank" rel="noopener noreferrer"
                        class="text-white hover:text-[#FF0F63] transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor" class="w-6 h-6">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=61555539331779" target="_blank"
                        rel="noopener noreferrer" class="text-white hover:text-[#FF0F63] transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor" class="w-6 h-6">
                            <path
                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                        </svg>
                    </a>
                </div>

                {{-- Copyright et mentions légales --}}
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-6 text-center sm:text-right">
                    <span class="text-sm text-white/70">© 2025 Calan'Couleurs. Tous droits réservés</span>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
