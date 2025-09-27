{{-- filepath: resources/views/partials/artistes/artiste-card-detailed.blade.php --}}

<div
    class="artiste-card-detailed group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
    <div class="relative aspect-[4/3]">
        <!-- ✅ BADGE SCÈNE AVEC LE STYLE PRÉFÉRÉ -->
        <div class="absolute top-2 right-2" style="z-index: 1;">
            @php
                $sceneColor = $artiste->scene === 'Extérieur' ? 'bg-[#FF0F63]' : 'bg-[#8F1E98]';
                $sceneIcon = $artiste->scene === 'Extérieur' ? '🌟' : '🏠';
            @endphp
            <span class="inline-block px-3 py-1 {{ $sceneColor }} text-white text-xs font-bold rounded-full">
                {{ $sceneIcon }} {{ $artiste->scene }}
            </span>
        </div>

        <!-- Photo -->
        <img src="{{ asset($artiste->photo) }}" alt="{{ $artiste->name }}" loading="lazy"
            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

        <!-- Overlay avec horaires -->
        <div class="absolute bottom-0 left-0 right-0 p-4"
            style="background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 100%);">
            <h3 class="text-white font-bold text-lg mb-1">{{ $artiste->name }}</h3>

            <div class="flex items-center justify-between text-white text-sm">
                <span class="font-medium">
                    {{ \Carbon\Carbon::parse($artiste->begin_date)->format('H\hi') }} -
                    {{ \Carbon\Carbon::parse($artiste->ending_date)->format('H\hi') }}
                </span>
                <span class="text-white/80">
                    {{ \Carbon\Carbon::parse($artiste->ending_date)->diffInMinutes(\Carbon\Carbon::parse($artiste->begin_date)) }}min
                </span>
            </div>
        </div>
    </div>

    <!-- Infos détaillées -->
    <div class="p-4">
        @if ($artiste->style)
            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $artiste->style }}</p>
        @endif

        @if ($artiste->description)
            <p class="text-gray-500 text-xs mb-3 line-clamp-3">{{ $artiste->description }}</p>
        @endif

        <!-- Liens streaming (si disponibles) -->
        @if ($artiste->spotify_url || $artiste->soundcloud_url || $artiste->youtube_url || $artiste->deezer_url)
            <div class="flex space-x-2 pt-2 border-t border-gray-100">
                @if ($artiste->spotify_url)
                    <a href="{{ $artiste->spotify_url }}" target="_blank"
                        class="text-green-600 hover:text-green-700 text-xs">
                        🎵 Spotify
                    </a>
                @endif
                @if ($artiste->soundcloud_url)
                    <a href="{{ $artiste->soundcloud_url }}" target="_blank"
                        class="text-orange-600 hover:text-orange-700 text-xs">
                        🔊 SoundCloud
                    </a>
                @endif
                @if ($artiste->youtube_url)
                    <a href="{{ $artiste->youtube_url }}" target="_blank"
                        class="text-red-600 hover:text-red-700 text-xs">
                        📺 YouTube
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
