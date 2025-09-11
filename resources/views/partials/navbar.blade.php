<!-- filepath: c:\Users\cagbo\Documents\GitHub\calan-app\resources\views\partials\navbar.blade.php -->
<div id="navbar-root"
    data-home-url="{{ url('/') }}"
    data-programmation-url="{{ url('/programmation') }}"
    data-festival-url="{{ url('/notre-histoire') }}"
    data-contact-url="{{ url('/contact') }}"
    data-billetterie-url="https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs"
    {{-- data-camping-url="{{ url('/camping') }}" --}}
    data-benevoles-url="{{ url('/benevoles') }}"
    data-news-url="{{ url('/news') }}"
    data-charte-url="{{ url('/charte') }}"
    data-partenaires-url="{{ url('/partenaires') }}"
    data-current-path="{{ request()->path() }}">
</div>
