{{-- filepath: resources/views/partials/artistes/artiste-card.blade.php --}}

<div
    class="artiste-card group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
    <div class="relative aspect-[3/4]">
        <!-- Badge jour (si demandé) -->
        @if ($show_day ?? false)
            <div class="absolute top-2 right-2" style="z-index: 1;">
                @php
                    $beginDate = \Carbon\Carbon::parse($artiste->begin_date);
                    $dayLabel = $beginDate->format('j/m');
                @endphp
                <span class="inline-block px-3 py-1 bg-black/70 text-white text-xs font-bold rounded-full">
                    {{ $dayLabel }}
                </span>
            </div>
        @endif

        <!-- Photo -->
        <img src="{{ asset($artiste->photo) }}" alt="{{ $artiste->name }}" loading="lazy"
            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

        <!-- Overlay avec infos -->
        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
            style="background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 50%, transparent 100%);">
            <div class="absolute bottom-0 left-0 right-0 p-3">
                <h3 class="text-white font-bold text-sm mb-1">{{ $artiste->name }}</h3>
                @if ($artiste->style)
                    <p class="text-white/80 text-xs">{{ $artiste->style }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Infos sous la photo -->
    <div class="p-3">
        <h3 class="font-bold text-gray-900 text-sm mb-1 line-clamp-1">{{ $artiste->name }}</h3>
        @if ($artiste->style)
            <p class="text-gray-500 text-xs mb-2 line-clamp-2">{{ $artiste->style }}</p>
        @endif

        <!-- Heure et scène -->
        <div class="flex items-center justify-between text-xs text-gray-400">
            <span>{{ \Carbon\Carbon::parse($artiste->begin_date)->format('H\hi') }}</span>
            @if ($artiste->scene)
                <span class="bg-gray-100 px-2 py-1 rounded">{{ $artiste->scene }}</span>
            @endif
        </div>
    </div>
</div>
