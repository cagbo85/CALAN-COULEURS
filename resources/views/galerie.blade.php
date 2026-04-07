@extends('layouts.app')

@section('title', 'Galerie officielle - Calan\'Couleurs Festival')

@section('content')
    <div class="w-full pt-8 px-4 py-12 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">

        @if ($editions->isEmpty())
            <div class="max-w-2xl mx-auto">
                <article class="bg-white/95 backdrop-blur-sm rounded-xl shadow-xl overflow-hidden border-2 border-white/50">
                    <div class="p-8 text-white" style="background: linear-gradient(to right, #FF0F63, #8F1E98);">
                        <h2 class="text-center sm:text-left text-3xl font-bold uppercase tracking-wide">
                            📸 Galerie à venir !
                        </h2>
                    </div>
                    <div class="p-8 text-center">
                        <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                            Les photos des éditions passées seront bientôt disponibles.
                        </p>
                        <p class="text-base text-gray-600 mb-6">
                            Restez connectés pour revivre les meilleurs moments du festival ! 🎶
                        </p>
                        <div class="flex justify-center gap-2 mb-2">
                            <div class="w-2 h-2 bg-[#FF0F63] rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-[#8F1E98] rounded-full animate-bounce" style="animation-delay: 0.1s">
                            </div>
                            <div class="w-2 h-2 bg-[#272AC7] rounded-full animate-bounce" style="animation-delay: 0.2s">
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        @else
            <!-- En-tête -->
            <div class="max-w-11xl mx-auto mb-12">
                <div class="text-center mb-8">
                    <h1 class="text-4xl sm:text-5xl font-bold text-[#8F1E98] mb-4">
                        Calan'Couleurs en photos
                    </h1>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Découvrez les meilleurs moments du festival à travers notre galerie officielle.
                    </p>
                </div>

                <!-- Navigation par onglets -->
                <div class="border-b border-gray-200 mb-8">
                    <nav class="flex flex-wrap justify-center space-x-1 sm:space-x-8" role="tablist">
                        @foreach ($editions as $edition)
                            <button
                                class="gallery-tab px-4 py-3 text-sm font-medium border-b-2 {{ $loop->first ? 'border-[#FF0F63] text-[#FF0F63] hover:text-[#8F1E98] hover:border-gray-300' : 'border-transparent text-gray-500 hover:text-[#8F1E98] hover:border-gray-300' }}"
                                data-tab="year-{{ $edition->year }}" role="tab"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $edition->name ?? 'Édition ' . $edition->year }}
                            </button>
                        @endforeach
                    </nav>
                </div>
            </div>

            <!-- Contenu des onglets -->
            <div class="max-w-11xl mx-auto">
                <!-- Contenu des onglets par année -->
                @foreach ($editions as $edition)
                    <div id="tab-year-{{ $edition->year }}" class="gallery-tab-content {{ $loop->first ? '' : 'hidden' }}"
                        role="tabpanel">
                        @if ($galleryByYear[$edition->year]->isEmpty())
                            <article
                                class="max-w-4xl mx-auto bg-white/95 backdrop-blur-sm rounded-xl shadow-xl overflow-hidden border-2 border-white/50">
                                <div class="p-8 text-white"
                                    style="background: linear-gradient(to right, #FF0F63, #8F1E98);">
                                    <h2 class="text-center sm:text-left text-3xl font-bold uppercase tracking-wide">
                                        📸 les souvenirs sont en train de se préparer...
                                    </h2>
                                </div>
                                <div class="p-8 text-center">
                                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                                        Les photos  de l'édition {{ $edition->year }} seront bientôt disponibles.
                                    </p>
                                    <p class="text-base text-gray-600 mb-6">
                                        Restez connectés pour revivre les meilleurs moments du festival ! 🎶
                                    </p>
                                    <div class="flex justify-center gap-2 mb-2">
                                        <div class="w-2 h-2 bg-[#FF0F63] rounded-full animate-bounce"></div>
                                        <div class="w-2 h-2 bg-[#8F1E98] rounded-full animate-bounce"
                                            style="animation-delay: 0.1s">
                                        </div>
                                        <div class="w-2 h-2 bg-[#272AC7] rounded-full animate-bounce"
                                            style="animation-delay: 0.2s">
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @else
                            <div class="columns-2 sm:columns-3 lg:columns-4 gap-4">
                                @foreach ($galleryByYear[$edition->year] as $image)
                                    <div class="break-inside-avoid mb-4">
                                        <button
                                            class="w-full block rounded-lg overflow-hidden focus-visible:outline focus-visible:outline-2 focus-visible:outline-white"
                                            onclick="openModal('{{ asset($image) }}', {{ $edition->year }})"
                                            aria-label="Ouvrir l'image {{ $loop->index + 1 }} en plein écran">
                                            <img src="{{ asset($image) }}" alt="Image galerie {{ $loop->index + 1 }}"
                                                class="w-full block transition-[transform,opacity] duration-300 hover:scale-[1.02] hover:opacity-90">
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Modal lightbox -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black/85 z-50 flex justify-center items-center" role="dialog"
        aria-modal="true" aria-label="Visionneuse d'images">
        <button
            class="absolute top-4 right-7 text-4xl text-white bg-transparent border-none cursor-pointer hover:text-red-400 leading-none"
            onclick="closeModal()" aria-label="Fermer">&times;</button>
        <button
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/15 border-none text-white text-6xl leading-none px-4 py-2 rounded-lg cursor-pointer hover:bg-white/30 select-none"
            onclick="navigate(-1)" aria-label="Image précédente">&#8249;</button>
        <img class="max-w-[90vw] max-h-[90vh] rounded-lg object-contain shadow-2xl" id="modalImage" alt="">
        <button
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/15 border-none text-white text-6xl leading-none px-4 py-2 rounded-lg cursor-pointer hover:bg-white/30 select-none"
            onclick="navigate(1)" aria-label="Image suivante">&#8250;</button>
        <span class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white text-sm bg-black/40 px-3 py-1 rounded-full"
            id="modalCounter"></span>
    </div>

    <script>
        const galleryByYear = @json(collect($galleryByYear)->map(fn($imgs) => $imgs->values()));

        let currentImages = [];
        let currentIndex = 0;

        function openModal(imgSrc, year) {
            currentImages = galleryByYear[year] ?? [];
            currentIndex = currentImages.findIndex(img => imgSrc.includes(img));
            updateModal();
            document.getElementById("imageModal").classList.remove("hidden");
        }

        function updateModal() {
            document.getElementById("modalImage").src = "{{ asset('') }}" + currentImages[currentIndex];
            document.getElementById("modalCounter").textContent = (currentIndex + 1) + " / " + currentImages.length;
        }

        function navigate(direction) {
            currentIndex = (currentIndex + direction + currentImages.length) % currentImages.length;
            updateModal();
            event.stopPropagation();
        }

        function closeModal() {
            document.getElementById("imageModal").classList.add("hidden");
        }

        document.addEventListener("keydown", (e) => {
            if (document.getElementById("imageModal").classList.contains("hidden")) return;
            if (e.key === "ArrowRight") navigate(1);
            if (e.key === "ArrowLeft") navigate(-1);
            if (e.key === "Escape") closeModal();
        });

        // Tabs
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".gallery-tab").forEach(btn => {
                btn.addEventListener("click", function() {
                    document.querySelectorAll(".gallery-tab").forEach(b => {
                        b.classList.remove("border-[#FF0F63]", "text-[#FF0F63]");
                        b.classList.add("border-transparent", "text-gray-500");
                        b.setAttribute("aria-selected", "false");
                    });
                    document.querySelectorAll(".gallery-tab-content").forEach(c => c.classList.add(
                        "hidden"));

                    this.classList.add("border-[#FF0F63]", "text-[#FF0F63]");
                    this.classList.remove("border-transparent", "text-gray-500");
                    this.setAttribute("aria-selected", "true");

                    document.getElementById("tab-" + this.dataset.tab)?.classList.remove("hidden");
                });
            });
        });
    </script>
@endsection
