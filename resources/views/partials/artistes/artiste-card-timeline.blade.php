{{-- filepath: resources/views/partials/artistes/artiste-card-timeline.blade.php --}}

<div class="artist-card group">
    <div class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
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

        <!-- Photo plus grande -->
        <img src="{{ asset($artiste->photo) }}" alt="{{ $artiste->name }}" loading="lazy"
            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

        <!-- Overlay avec infos complètes -->
        <div class="absolute bottom-0 left-0 right-0 p-3"
            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
            <h3 class="text-white font-bold text-base mb-1">{{ $artiste->name }}</h3>
            <p class="text-white text-xs flex items-center justify-between">
                @php
                    $beginDate = \Carbon\Carbon::parse($artiste->begin_date);
                    $endDate = \Carbon\Carbon::parse($artiste->ending_date);
                    $dayLabel = $beginDate->format('l') === 'Friday' ? 'VEN 12' : 'SAM 13';
                @endphp
                <span class="font-medium">{{ $dayLabel }}</span>
                <span class="font-medium">
                    {{ $beginDate->format('H\hi') }} - {{ $endDate->format('H\hi') }}
                </span>
            </p>
        </div>
    </div>
</div>
