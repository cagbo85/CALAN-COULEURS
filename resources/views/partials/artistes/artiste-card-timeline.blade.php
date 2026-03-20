<div class="artist-card group">
    <div class="relative overflow-hidden rounded-lg aspect-[3/4] hover:shadow-lg transition-all duration-300">
        <!-- Badge scène -->
        <div class="absolute top-2 right-2" style="z-index: 1;">
            <span class="inline-block px-3 py-1 {{ $artiste->sceneColor }} text-white text-xs font-bold rounded-full">
                {{ $artiste->sceneIcon }} {{ $artiste->scene }}
            </span>
        </div>

        <!-- Photo -->
        <img src="{{ asset($artiste->photo) }}" alt="{{ $artiste->name }}" loading="lazy"
            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

        <!-- Overlay infos -->
        <div class="absolute bottom-0 left-0 right-0 p-3"
            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
            <h3 class="text-white font-bold text-base mb-1">{{ $artiste->name }}</h3>
            <p class="text-white text-xs flex items-center justify-between">
                <span class="font-medium uppercase">{{ $artiste->festival_day_label_court }}</span>
                <span class="font-medium">
                    {{ $artiste->formatted_begin_date }} - {{ $artiste->formatted_ending_date }}
                </span>
            </p>
        </div>
    </div>
</div>
