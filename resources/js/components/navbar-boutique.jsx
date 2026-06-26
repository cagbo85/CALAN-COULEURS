import { useEffect, useRef, useState } from "react";

export default function NavbarBoutique({ routes, initialCartCount = 0 }) {
    const [isOpen, setIsOpen] = useState(false);
    const [activeDropdown, setActiveDropdown] = useState(null);
    const firstMobileLinkRef = useRef(null);
    const [cartCount, setCartCount] = useState(initialCartCount);
    const btnRef = useRef(null);

    useEffect(() => {
        function onKeyDown(e) {
            if (e.key === "Escape") {
                if (activeDropdown) {
                    setActiveDropdown(null);
                } else if (isOpen) {
                    setIsOpen(false);
                    btnRef.current?.focus();
                }
            }
        }
        window.addEventListener("keydown", onKeyDown);
        return () => window.removeEventListener("keydown", onKeyDown);
    }, [isOpen, activeDropdown]);

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

    useEffect(() => {
        if (isOpen) {
            firstMobileLinkRef.current?.focus();
        }
    }, [isOpen]);

    const openCartPanel = (e) => {
        e.preventDefault();

        if (typeof window.openCartPanel === "function") {
            window.openCartPanel();
            return;
        }

        window.location.href = "/panier";
    };

    // Fermer les dropdowns quand on clique ailleurs
    useEffect(() => {
        function handleClickOutside(e) {
            if (!e.target.closest(".dropdown-container")) {
                setActiveDropdown(null);
            }
        }
        document.addEventListener("click", handleClickOutside);
        return () => document.removeEventListener("click", handleClickOutside);
    }, []);

    const toggleDropdown = (dropdownName) => {
        setActiveDropdown(
            activeDropdown === dropdownName ? null : dropdownName,
        );
    };

    return (
        <div className="relative z-50 bg-white shadow-md">
            <div className="container px-4 mx-auto sm:px-6 lg:px-8">
                <div className="items-center justify-between hidden py-4 lg:flex">
                    {/* Logo */}
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

                    {/* Menu Desktop */}
                    <nav
                        className="items-center space-x-1 lg:flex"
                        aria-label="Navigation principale"
                    >
                        <a
                            href={routes?.home || "/boutique"}
                            className="block py-2 px-3 text-[#1d3f89] font-semibold hover:text-[#8F1E98] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                        >
                            Accueil
                        </a>

                        {/* Vêtements Dropdown */}
                        <div className="relative dropdown-container">
                            <button
                                onClick={() => toggleDropdown("vetements")}
                                className="flex items-center gap-2 py-2 px-3 text-[#1d3f89] font-semibold hover:text-[#8F1E98] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                                aria-expanded={activeDropdown === "vetements"}
                                aria-haspopup="true"
                            >
                                Vêtements
                                <i
                                    className={`fa-solid fa-chevron-down inline-block text-xs transition-transform duration-300 ${
                                        activeDropdown === "vetements"
                                            ? "rotate-90"
                                            : ""
                                    }`}
                                ></i>
                            </button>

                            {activeDropdown === "vetements" && (
                                <div className="absolute left-0 w-48 py-2 mt-1 bg-white border border-gray-100 rounded-lg shadow-lg top-full">
                                    <a
                                        href="/boutique/produits?badge=nouveaute"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        Nouveautés Édition 2026 🔥
                                    </a>
                                    <a
                                        href="/boutique/produits?badge=t-shirt"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        T-shirts
                                    </a>
                                    <a
                                        href="/boutique/produits?badge=pull"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        Pulls Demi-Zip
                                    </a>
                                    <a
                                        href="/boutique/produits?badge=pull"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        Sweats
                                    </a>
                                </div>
                            )}
                        </div>

                        {/* Accessoires Dropdown */}
                        <div className="relative dropdown-container">
                            <button
                                onClick={() => toggleDropdown("accessoires")}
                                className="flex items-center gap-2 py-2 px-3 text-[#1d3f89] font-semibold hover:text-[#8F1E98] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                                aria-expanded={activeDropdown === "accessoires"}
                                aria-haspopup="true"
                            >
                                Accessoires
                                <i
                                    className={`fa-solid fa-chevron-down inline-block text-xs transition-transform duration-300 ${
                                        activeDropdown === "accessoires"
                                            ? "rotate-90"
                                            : ""
                                    }`}
                                ></i>
                            </button>

                            {activeDropdown === "accessoires" && (
                                <div className="absolute left-0 w-48 py-2 mt-1 bg-white border border-gray-100 rounded-lg shadow-lg top-full">
                                    <a
                                        href="/boutique/produits?badge=nouveaute"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        Nouveautés Édition 2026 🔥
                                    </a>
                                    <a
                                        href="/boutique/produits?badge=accessoire"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        Bobs
                                    </a>
                                    <a
                                        href="/boutique/produits?badge=accessoire"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        Casquettes
                                    </a>
                                    <a
                                        href="/boutique/produits?badge=accessoire"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        Lunettes
                                    </a>
                                    <a
                                        href="/boutique/produits?badge=accessoire"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        Gourdes
                                    </a>
                                    <a
                                        href="/boutique/produits?badge=accessoire"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        Tote Bags
                                    </a>
                                </div>
                            )}
                        </div>

                        <a
                            href={routes?.contact || "/boutique/contact"}
                            className="block py-2 px-3 text-[#1d3f89] font-semibold hover:text-[#8F1E98] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
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
            <div className="container px-4 mx-auto sm:px-6 lg:hidden">
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

            {/* Menu Mobile */}
            <div
                id="mobile-menu"
                className={`lg:hidden absolute left-0 right-0 top-full bg-white shadow-xl transition-all duration-300 motion-reduce:transition-none ${
                    isOpen
                        ? "max-h-screen opacity-100 visible"
                        : "max-h-0 opacity-0 invisible"
                } overflow-y-auto`}
                hidden={!isOpen}
                aria-label="Navigation principale mobile"
            >
                <nav className="px-4 py-4 space-y-2 bg-white border-t border-gray-100">
                    {/* Accueil Mobile */}
                    <a
                        href={routes?.home || "/boutique"}
                        ref={firstMobileLinkRef}
                        className="block py-2 font-semibold text-[#1d3f89]"
                    >
                        Accueil
                    </a>

                    {/* Vêtements Mobile */}
                    <div className="mb-4">
                        <h3 className="block py-2 font-semibold text-[#1d3f89]">
                            Vêtements
                        </h3>
                        <a
                            href="/boutique/produits?badge=pull"
                            className="block py-2 pl-4 text-gray-700 transition"
                        >
                            T-shirts
                        </a>
                        <a
                            href="/boutique/produits?badge=pull"
                            className="block py-2 pl-4 text-gray-700 transition"
                        >
                            Pulls Demi-Zip
                        </a>
                        <a
                            href="/boutique/produits?badge=pull"
                            className="block py-2 pl-4 text-gray-700 transition"
                        >
                            Sweats
                        </a>
                    </div>

                    {/* Accessoires Mobile */}
                    <div className="mb-4">
                        <h3 className="block py-2 font-semibold text-[#1d3f89]">
                            Accessoires
                        </h3>
                        <a
                            href="/boutique/produits?badge=accessoire"
                            className="block py-2 pl-4 text-gray-700 transition"
                        >
                            Bobs
                        </a>
                        <a
                            href="/boutique/produits?badge=accessoire"
                            className="block py-2 pl-4 text-gray-700 transition"
                        >
                            Casquettes
                        </a>
                        <a
                            href="/boutique/produits?badge=accessoire"
                            className="block py-2 pl-4 text-gray-700 transition"
                        >
                            Lunettes
                        </a>
                        <a
                            href="/boutique/produits?badge=accessoire"
                            className="block py-2 pl-4 text-gray-700 transition"
                        >
                            Gourdes
                        </a>
                        <a
                            href="/boutique/produits?badge=accessoire"
                            className="block py-2 pl-4 text-gray-700 transition"
                        >
                            Tote Bags
                        </a>
                    </div>

                    <a
                        href={routes?.contact || "/boutique/contact"}
                        className="block py-2 font-semibold text-[#1d3f89]"
                    >
                        Contact
                    </a>
                </nav>
            </div>
        </div>
    );
}
