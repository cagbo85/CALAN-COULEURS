<div class="artist-card group">
    <div class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
        <!-- Photo plus grande et plus visible -->
        <img src="{{ asset($artiste->photo) }}" alt="{{ $artiste->name }}" loading="lazy"
            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

        <!-- Overlay avec infos minimales -->
        <div class="absolute bottom-0 left-0 right-0 p-3"
            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
            <h3 class="text-white font-bold text-base mb-1">{{ $artiste->name }}</h3>
            <p class="text-white text-xs">
                @php
                    $beginDate = \Carbon\Carbon::parse($artiste->begin_date);
                    $dayLabel = $beginDate->format('l') === 'Friday' ? 'VEN 12' : 'SAM 13';
                    $badgeColor = $beginDate->format('l') === 'Friday' ? 'bg-[#FF0F63]' : 'bg-[#8F1E98]';
                @endphp
                <span class="inline-block px-2 py-1 {{ $badgeColor }} rounded-full text-xs font-medium">
                    {{ $dayLabel }}
                </span>
            </p>
        </div>
    </div>
</div>
