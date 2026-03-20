<div id="navbar-root"
    data-home-url="{{ url('/') }}"
    @if ($showProgrammation ?? false)
        data-programmation-url="{{ url('/programmation') }}"
    @endif
    data-festival-url="{{ url('/notre-histoire') }}"
    data-contact-url="{{ url('/contact') }}"
    data-boutique-url="{{ url('/boutique') }}"
    data-billetterie-url="{{ $currentEdition->reservation_url }}"
    data-camping-url="{{ url('/camping') }}"
    data-benevoles-url="{{ url('/benevoles') }}"
    data-charte-url="{{ url('/charte') }}"
    @if ($showPartenaires ?? false)
    data-partenaires-url="{{ url('/partenaires') }}"
    @endif
    @if ($showNews ?? false)
        data-news-url="{{ url('#') }}"
    @endif
    @if ($showPhotoSouvenirs ?? false)
        data-photo-souvenirs-url="{{ url('#') }}"
    @endif
    data-current-path="{{ request()->path() }}">
</div>
