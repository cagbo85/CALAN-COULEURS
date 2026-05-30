@extends('layouts.app')

@section('title', 'Contact - Calan\'Couleurs Festival ' . $currentEdition->year)

@push('styles')
    <style>
        .div-input-contact {
            border: 2px solid transparent;
            border-radius: 12px;
            background: linear-gradient(white, white) padding-box, linear-gradient(135deg, #272AC7, #8F1E98) border-box;
        }
    </style>
@endpush


@section('content')
    <section class="w-full h-[280px] sm:h-[320px] bg-cover bg-center bg-no-repeat flex items-center justify-center"
        style="background-image: linear-gradient(rgba(39, 42, 199, 0.65), rgba(143, 30, 152, 0.45)), url('/img/logos/accueil_public.png')">
        <div class="px-4 text-center">
            <h1 class="mb-3 text-4xl font-bold text-white sm:text-5xl drop-shadow-lg">
                Contactez-nous
            </h1>
            <p class="text-lg text-white/90">
                Une question, une idée, une envie de participer ? On est là.
            </p>
        </div>
    </section>

    <section class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="container grid items-start max-w-6xl grid-cols-1 gap-8 mx-auto lg:grid-cols-2 lg:gap-10">
            <!-- Colonne Infos -->
            <div class="h-full p-6 bg-white border border-gray-100 shadow-md rounded-2xl sm:p-8 lg:sticky lg:top-24">
                <h2 class="text-3xl font-bold text-[#272AC7] mb-8">Restons en contact</h2>

                <div class="space-y-12">
                    <!-- Email -->
                    <div class="flex flex-col items-center gap-6 md:flex-row">
                        <div class="flex items-center justify-center w-16 h-16 bg-[#272AC7]/10 rounded-full">
                            <i class="fa-solid fa-envelope fa-2xl text-[#272AC7]"></i>
                        </div>
                        <div class="text-center md:text-left">
                            <h3 class="text-xl font-semibold text-[#272AC7] mb-2">Par email</h3>
                            <p class="mb-3 text-gray-600">Pour toute question ou demande d'information :</p>
                            <a href="mailto:calancouleurs@gmail.com"
                                class="text-[#FF0F63] hover:text-[#8F1E98] text-xl font-bold transition-colors duration-300">
                                calancouleurs@gmail.com
                            </a>
                        </div>
                    </div>

                    <!-- Téléphone -->
                    <div class="flex flex-col items-center gap-6 md:flex-row">
                        <div class="flex items-center justify-center w-16 h-16 bg-[#272AC7]/10 rounded-full">
                            <div class="flex items-center justify-center w-16 h-16 bg-[#272AC7]/10 rounded-full">
                                <i class="fa-solid fa-phone fa-2xl text-[#272AC7]"></i>
                            </div>
                        </div>
                        <div class="text-center md:text-left">
                            <h3 class="text-xl font-semibold text-[#272AC7] mb-2">Par téléphone</h3>
                            <p class="mb-3 text-gray-600">Pour nous joindre directement :</p>

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

                            <p class="mt-3 text-sm italic text-gray-600">
                                Ces contacts sont strictement réservés aux demandes concernant le festival.
                            </p>
                        </div>
                    </div>

                    <!-- Réseaux sociaux -->
                    <div class="flex flex-col items-center gap-6 md:flex-row">
                        <div class="flex items-center justify-center w-16 h-16 bg-[#272AC7]/10 rounded-full">
                            <div class="flex items-center justify-center w-16 h-16 bg-[#272AC7]/10 rounded-full">
                                <i class="fa-solid fa-bolt fa-2xl text-[#272AC7]"></i>
                            </div>
                        </div>
                        <div class="text-center md:text-left">
                            <h3 class="text-xl font-semibold text-[#272AC7] mb-2">Réseaux sociaux</h3>
                            <p class="mb-3 text-gray-600">Suivez-nous pour ne rien manquer :</p>
                            <div class="flex justify-center space-x-4 md:justify-start">
                                <a href="https://www.instagram.com/calancouleurs/" target="_blank" rel="noopener noreferrer"
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

            <!-- Colonne Formulaire de contact -->
            <div class="h-full p-6 bg-white border border-gray-100 shadow-md rounded-2xl sm:p-8 lg:sticky lg:top-24">
                <h2 class="text-3xl font-bold text-[#272AC7]">Envie de nous écrire?</h2>
                <p class="text-[#272AC7] mb-8">Une question sur la programmation, une idée brillante à nous partager, envie
                    de devenir bénévole? Vous êtes au bon endroit!</p>
                @if (session('success'))
                    <div class="p-3 mb-5 text-green-800 bg-green-100 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="p-3 rounded-lg div-input-contact">
                        <label class="block mb-1 font-medium text-gray-700">Nom <span class="text-red-500">*</span>
                            :</label>
                        <input type="text" name="name" class="w-full rounded-lg focus:outline-none" required
                            value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="p-3 rounded-lg div-input-contact">
                        <label class="block font-medium text-gray-700">Email <span class="text-red-500">*</span> :</label>
                        <input type="email" name="email" class="w-full rounded-lg focus:outline-none" required
                            value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="p-3 rounded-lg div-input-contact">
                        <label class="block font-medium text-gray-700">Message <span class="text-red-500">*</span>
                            :</label>
                        <textarea name="message" rows="6" class="w-full rounded-lg focus:outline-none" required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="px-6 py-3 font-semibold text-white transition-all duration-300 rounded-lg shadow tab-button-goto hover:shadow-lg"
                        style="background: linear-gradient(90deg, #272ac7 0%, #8f1e98 100%)">
                        Envoyer
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
