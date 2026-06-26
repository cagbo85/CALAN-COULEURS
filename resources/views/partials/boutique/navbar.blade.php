<div id="navbarBoutique-root"
    data-home-url="{{ url('/boutique') }}"
    data-pulls-url="{{ url('/boutique/produits?badge=pull') }}"
    data-tshirts-url="{{ url('/boutique/produits?badge=t-shirt') }}"
    data-accessoires-url="{{ url('/boutique/produits?badge=accessoire') }}"
    data-contact-url="{{ route('boutique.contact') }}"
    data-cart-url="{{ route('boutique.cart') }}"
    data-cart-count="{{ array_sum(array_column(session('cart', []), 'quantity')) }}">
</div>
