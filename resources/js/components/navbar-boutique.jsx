import { useEffect, useRef, useState } from "react";

export default function NavbarBoutique({ routes, initialCartCount = 0 }) {
    const [isOpen, setIsOpen] = useState(false);
    const [cartCount, setCartCount] = useState(initialCartCount);
    const btnRef = useRef(null);

    useEffect(() => {
        function onKeyDown(e) {
            if (e.key === "Escape") {
                if (isOpen) {
                    setIsOpen(false);
                    btnRef.current?.focus();
                }
            }
        }

        window.addEventListener("keydown", onKeyDown);
        return () => window.removeEventListener("keydown", onKeyDown);
    }, [isOpen]);

    useEffect(() => {
        window.updateCartCounter = function (count) {
            setCartCount(Number(count) || 0);
        };

        return () => {
            if (window.updateCartCounter) {
                window.updateCartCounter = undefined;
            }
        };
    }, []);

    const openCartPanel = (e) => {
        e.preventDefault();

        if (typeof window.openCartPanel === "function") {
            window.openCartPanel();
            return;
        }

        window.location.href = "/panier";
    };

    return (
        <div className="relative z-50 bg-white shadow-md">
            <div className="px-4 mx-auto sm:px-6 lg:px-8">
                <div className="items-center justify-between hidden py-4 lg:flex">
                    <a
                        href={routes?.home || "/boutique"}
                        className="flex items-center"
                        aria-label="Aller à l'accueil de la boutique"
                    >
                        <img
                            src="/img/logos/LOGO/Logo-Calan.png"
                            alt="Calan'Couleurs"
                            className="h-12"
                        />
                    </a>

                    <nav
                        className="items-center space-x-1 lg:flex"
                        aria-label="Navigation principale"
                    >
                        <a
                            href="/boutique"
                            className="block px-3 py-2 font-semibold transition rounded text-[#1d3f89] hover:text-[#8F1E98]"
                        >
                            Calan'Boutique
                        </a>

                        <a
                            href={
                                routes?.pulls || "/boutique/produits?badge=pull"
                            }
                            className="block px-3 py-2 font-semibold transition rounded text-[#1d3f89] hover:text-[#8F1E98]"
                        >
                            Pulls
                        </a>

                        <a
                            href={
                                routes?.tshirts ||
                                "/boutique/produits?badge=t-shirt"
                            }
                            className="block px-3 py-2 font-semibold transition rounded text-[#1d3f89] hover:text-[#8F1E98]"
                        >
                            T-shirts
                        </a>

                        <a
                            href={
                                routes?.accessoires ||
                                "/boutique/produits?badge=accessoire"
                            }
                            className="block px-3 py-2 font-semibold transition rounded text-[#1d3f89] hover:text-[#8F1E98]"
                        >
                            Accessoires
                        </a>

                        <a
                            href={routes?.contact || "/boutique/contact"}
                            className="block px-3 py-2 font-semibold transition rounded text-[#1d3f89] hover:text-[#8F1E98]"
                        >
                            Contact
                        </a>
                    </nav>

                    <button
                        type="button"
                        onClick={openCartPanel}
                        style={{
                            background:
                                "linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%)",
                        }}
                        className="relative inline-flex items-center gap-2 text-white font-semibold px-6 py-2.5 rounded-lg transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#8F1E98] shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                        <i
                            className="fa-solid fa-cart-shopping"
                            aria-hidden="true"
                        ></i>
                        <span>Panier</span>
                        {cartCount > 0 && (
                            <span className="absolute -top-2 -right-2 bg-[#8F1E98] text-white text-[10px] font-extrabold min-w-5 h-5 px-1 flex items-center justify-center rounded-full border-2 border-white">
                                {cartCount}
                            </span>
                        )}
                    </button>
                </div>
            </div>
            <div className="px-4 mx-auto sm:px-6 lg:hidden">
                <div className="flex items-center justify-between py-4 lg:hidden">
                    <button
                        ref={btnRef}
                        type="button"
                        onClick={() => setIsOpen((open) => !open)}
                        className="p-1 text-[#1d3f89] focus:outline-none"
                        aria-controls="mobile-menu"
                        aria-expanded={isOpen}
                        aria-label={
                            isOpen ? "Fermer le menu" : "Ouvrir le menu"
                        }
                    >
                        {isOpen ? (
                            <i className="fa-solid fa-xmark fa-xl"></i>
                        ) : (
                            <i className="fa-solid fa-bars fa-xl"></i>
                        )}
                    </button>

                    <a
                        href={routes?.home || "/boutique"}
                        className="flex items-center justify-center"
                        aria-label="Aller à l'accueil de la boutique"
                    >
                        <img
                            src="/img/logos/LOGO/Logo-Calan.png"
                            alt="Calan'Couleurs"
                            className="h-12"
                        />
                    </a>

                    <a
                        href={routes?.cart || "/panier"}
                        className="relative p-1 text-[#1d3f89] focus:outline-none"
                        aria-label="Voir le panier"
                    >
                        <i className="fa-solid fa-cart-shopping fa-xl"></i>
                        {cartCount > 0 && (
                            <span className="absolute -top-1 -right-1 bg-[#8F1E98] text-white text-[10px] font-extrabold min-w-5 h-5 px-1 flex items-center justify-center rounded-full border-2 border-white">
                                {cartCount}
                            </span>
                        )}
                    </a>
                </div>
            </div>

            <div
                id="mobile-menu"
                className={`lg:hidden overflow-hidden transition-all duration-300 ${
                    isOpen
                        ? "max-h-screen opacity-100 visible"
                        : "max-h-0 opacity-0 invisible"
                }`}
                hidden={!isOpen}
                aria-label="Navigation principale mobile"
            >
                <nav className="px-4 py-4 space-y-4 bg-white border-t border-gray-100">
                    <a
                        href="/boutique"
                        className="block py-2 font-semibold text-[#1d3f89]"
                    >
                        Calan'Boutique
                    </a>

                    <a
                        href={routes?.pulls || "/boutique/produits?badge=pull"}
                        className="block py-2 text-gray-700 hover:text-[#1d3f89]"
                    >
                        Pulls
                    </a>

                    <a
                        href={
                            routes?.tshirts ||
                            "/boutique/produits?badge=t-shirt"
                        }
                        className="block py-2 text-gray-700 hover:text-[#1d3f89]"
                    >
                        T-shirts
                    </a>

                    <a
                        href={
                            routes?.accessoires ||
                            "/boutique/produits?badge=accessoire"
                        }
                        className="block py-2 text-gray-700 hover:text-[#1d3f89]"
                    >
                        Accessoires
                    </a>

                    <a
                        href={routes?.contact || "/boutique/contact"}
                        className="block py-2 text-gray-700 hover:text-[#1d3f89]"
                    >
                        Contact
                    </a>
                </nav>
            </div>
        </div>
    );
}
