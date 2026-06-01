@extends('layouts.app')

@section('title', 'Galerie officielle - Calan\'Couleurs Festival')

@section('content')
    <div class="w-full min-h-screen px-4 py-12 pt-8 sm:px-6 lg:px-8 bg-[#EEF1FF]">

        @if ($editions->isEmpty())
            <div class="max-w-2xl mx-auto">
                <article class="overflow-hidden border-2 shadow-xl bg-white/95 backdrop-blur-sm rounded-xl border-white/50">
                    <div class="p-8 text-white" style="background: linear-gradient(135deg, #1d3f89 0%, #77cbf3 100%)">
                        <h2 class="text-3xl font-bold tracking-wide text-center uppercase sm:text-left">
                            📸 Galerie à venir !
                        </h2>
                    </div>
                    <div class="p-8 text-center">
                        <p class="mb-4 text-lg leading-relaxed text-gray-700">
                            Les photos des éditions passées seront bientôt disponibles.
                        </p>
                        <p class="mb-6 text-base text-gray-600">
                            Restez connectés pour revivre les meilleurs moments du festival ! 🎶
                        </p>
                        <div class="flex justify-center gap-2 mb-2">
                            <div class="w-2 h-2 bg-[#1d3f89] rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-[#8F1E98] rounded-full animate-bounce" style="animation-delay: 0.1s">
                            </div>
                            <div class="w-2 h-2 bg-[#FF0F63] rounded-full animate-bounce" style="animation-delay: 0.2s">
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        @else
            <div class="mx-auto mb-12 max-w-7xl">
                <div class="mb-8 text-center">
                    <h1 class="text-4xl sm:text-5xl font-bold text-[#1d3f89] mb-4">
                        Calan'Couleurs en photos
                    </h1>
                    <p class="max-w-2xl mx-auto text-lg text-gray-600">
                        Découvrez les meilleurs moments du festival à travers notre galerie officielle.
                    </p>
                </div>

                <div class="mb-8 border-b border-gray-200">
                    <nav class="flex flex-wrap justify-center space-x-1 sm:space-x-8" role="tablist">
                        @foreach ($editions as $edition)
                            <button
                                class="gallery-tab px-4 py-3 text-sm font-medium border-b-2 {{ $loop->first ? 'border-[#1d3f89] text-[#1d3f89] hover:text-[#8F1E98] hover:border-gray-300' : 'border-transparent text-gray-500 hover:text-[#8F1E98] hover:border-gray-300' }}"
                                data-tab="year-{{ $edition->year }}" role="tab"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $edition->name ?? 'Édition ' . $edition->year }}
                            </button>
                        @endforeach
                    </nav>
                </div>
            </div>

            <div class="mx-auto max-w-7xl">
                @foreach ($editions as $edition)
                    <div id="tab-year-{{ $edition->year }}" class="gallery-tab-content {{ $loop->first ? '' : 'hidden' }}"
                        role="tabpanel">
                        @if ($galleryByYear[$edition->year]->isEmpty())
                            <article
                                class="max-w-4xl mx-auto overflow-hidden border-2 shadow-xl bg-white/95 backdrop-blur-sm rounded-xl border-white/50">
                                <div class="p-8 text-white"
                                    style="background: linear-gradient(135deg, #1d3f89 0%, #77cbf3 100%)">
                                    <h2 class="text-3xl font-bold tracking-wide text-center uppercase sm:text-left">
                                        📸 Les souvenirs sont en train de se préparer...
                                    </h2>
                                </div>
                                <div class="p-8 text-center">
                                    <p class="mb-4 text-lg leading-relaxed text-gray-700">
                                        Les photos de l'édition {{ $edition->year }} seront bientôt disponibles.
                                    </p>
                                    <p class="mb-6 text-base text-gray-600">
                                        Restez connectés pour revivre les meilleurs moments du festival ! 🎶
                                    </p>
                                    <div class="flex justify-center gap-2 mb-2">
                                        <div class="w-2 h-2 bg-[#1d3f89] rounded-full animate-bounce"></div>
                                        <div class="w-2 h-2 bg-[#8F1E98] rounded-full animate-bounce"
                                            style="animation-delay: 0.1s"></div>
                                        <div class="w-2 h-2 bg-[#FF0F63] rounded-full animate-bounce"
                                            style="animation-delay: 0.2s"></div>
                                    </div>
                                </div>
                            </article>
                        @else
                            <div class="gap-5 columns-2 sm:columns-3 lg:columns-4">
                                @foreach ($galleryByYear[$edition->year] as $image)
                                    <div class="mb-5 break-inside-avoid">
                                        <button
                                            class="w-full block rounded-lg overflow-hidden shadow-sm hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-[#1d3f89]"
                                            onclick="openModal('{{ asset($image) }}', {{ $edition->year }})"
                                            aria-label="Ouvrir l'image {{ $loop->index + 1 }} en plein écran">
                                            <img src="{{ asset($image) }}" alt="Image galerie {{ $loop->index + 1 }}"
                                                class="w-full block transition-[transform,opacity] duration-300 hover:scale-[1.015] hover:opacity-95">
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
    <div id="imageModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/85" role="dialog"
        aria-modal="true" aria-label="Visionneuse d'images">
        <button
            class="absolute top-4 right-7 text-4xl text-white bg-transparent border-none cursor-pointer hover:text-[#8F1E98] leading-none"
            onclick="closeModal()" aria-label="Fermer">&times;</button>

        <button
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-[#1d3f89]/30 border-none text-white text-6xl leading-none px-4 py-2 rounded-lg cursor-pointer hover:bg-[#1d3f89]/50 select-none"
            onclick="navigate(-1)" aria-label="Image précédente">&#8249;</button>

        <img class="max-w-[90vw] max-h-[90vh] rounded-lg object-contain shadow-2xl" id="modalImage" alt="">

        <button
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-[#1d3f89]/30 border-none text-white text-6xl leading-none px-4 py-2 rounded-lg cursor-pointer hover:bg-[#1d3f89]/50 select-none"
            onclick="navigate(1)" aria-label="Image suivante">&#8250;</button>

        <span class="absolute px-3 py-1 text-sm text-white -translate-x-1/2 rounded-full bottom-4 left-1/2 bg-black/40"
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

        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".gallery-tab").forEach(btn => {
                btn.addEventListener("click", function() {
                    document.querySelectorAll(".gallery-tab").forEach(b => {
                        b.classList.remove("border-[#1d3f89]", "text-[#1d3f89]");
                        b.classList.add("border-transparent", "text-gray-500");
                        b.setAttribute("aria-selected", "false");
                    });

                    document.querySelectorAll(".gallery-tab-content").forEach(c => c.classList.add(
                        "hidden"));

                    this.classList.add("border-[#1d3f89]", "text-[#1d3f89]");
                    this.classList.remove("border-transparent", "text-gray-500");
                    this.setAttribute("aria-selected", "true");

                    document.getElementById("tab-" + this.dataset.tab)?.classList.remove("hidden");
                });
            });
        });
    </script>
@endsection
