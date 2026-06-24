import { useEffect, useRef, useState } from "react";

export default function Navbar({ routes }) {
    const [isOpen, setIsOpen] = useState(false);
    const [activeDropdown, setActiveDropdown] = useState(null);
    const btnRef = useRef(null);
    const firstMobileLinkRef = useRef(null);

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
        if (isOpen) {
            firstMobileLinkRef.current?.focus();
        }
    }, [isOpen]);

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
        <header className="relative z-50 bg-white shadow-md">
            <div className="container px-4 mx-auto sm:px-6 lg:px-8">
                <div className="flex items-center justify-between py-4">
                    {/* Logo */}
                    <a
                        href={routes?.home || "/"}
                        className="flex items-center"
                        aria-label="Aller à l'accueil"
                    >
                        <img
                            src="/img/logos/LOGO/Logo-Calan.png"
                            alt="Calan'Couleurs"
                            className="h-12"
                        />
                    </a>

                    {/* Menu Desktop */}
                    <nav
                        className="items-center hidden space-x-1 lg:flex"
                        aria-label="Navigation principale"
                    >
                        <a
                            href={routes?.accueil || "/"}
                            className="block py-2 px-3 text-[#1d3f89] font-semibold hover:text-[#8F1E98] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                        >
                            Accueil
                        </a>

                        {/* Infos Dropdown */}
                        <div className="relative dropdown-container">
                            <button
                                onClick={() => toggleDropdown("infos")}
                                className="flex items-center gap-2 py-2 px-3 text-[#1d3f89] font-semibold hover:text-[#8F1E98] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                                aria-expanded={activeDropdown === "infos"}
                                aria-haspopup="true"
                            >
                                Infos
                                <i
                                    className={`fa-solid fa-chevron-down inline-block text-xs transition-transform duration-300 ${
                                        activeDropdown === "infos"
                                            ? "rotate-90"
                                            : ""
                                    }`}
                                ></i>
                            </button>

                            {activeDropdown === "infos" && (
                                <div className="absolute left-0 w-48 py-2 mt-1 bg-white border border-gray-100 rounded-lg shadow-lg top-full">
                                    <a
                                        href="/camping"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        Camping & Hébergement
                                    </a>
                                    <a
                                        href="/benevoles"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        Bénévoles
                                    </a>
                                </div>
                            )}
                        </div>

                        {/* Festival Dropdown */}
                        <div className="relative dropdown-container">
                            <button
                                onClick={() => toggleDropdown("festival")}
                                className="flex items-center gap-2 py-2 px-3 text-[#1d3f89] font-semibold hover:text-[#8F1E98] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                                aria-expanded={activeDropdown === "festival"}
                                aria-haspopup="true"
                            >
                                Festival
                                <i
                                    className={`fa-solid fa-chevron-down inline-block text-xs transition-transform duration-300 ${
                                        activeDropdown === "festival"
                                            ? "rotate-90"
                                            : ""
                                    }`}
                                ></i>
                            </button>

                            {activeDropdown === "festival" && (
                                <div className="absolute left-0 py-2 mt-1 bg-white border border-gray-100 rounded-lg shadow-lg top-full w-52">
                                    {/* <a
                                        href="/news"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        News & Actualités
                                    </a> */}
                                    <a
                                        href="/charte"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        Charte du festivalier
                                    </a>
                                    <a
                                        href={
                                            routes?.festival ||
                                            "/notre-histoire"
                                        }
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                    >
                                        À propos
                                    </a>
                                    {routes?.partenaires && (
                                        <a
                                            href={routes.partenaires}
                                            className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#1d3f89] transition"
                                        >
                                            Nos Partenaires
                                        </a>
                                    )}
                                </div>
                            )}
                        </div>

                        <a
                            href={routes?.galerie || "/galerie"}
                            className="block py-2 px-3 text-[#1d3f89] font-semibold hover:text-[#8F1E98] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98]"
                        >
                            Galerie
                        </a>

                        {routes?.news && (
                            <a
                                href={routes.news}
                                className="block py-2 px-3 text-[#1d3f89] font-semibold hover:text-[#8F1E98] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                            >
                                Actualités
                            </a>
                        )}

                        {routes?.programmation && (
                            <a
                                href={routes.programmation}
                                className="block py-2 px-3 text-[#1d3f89] font-semibold hover:text-[#8F1E98] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                            >
                                Programmation
                            </a>
                        )}

                        <a
                            href={routes?.contact || "/contact"}
                            className="block py-2 px-3 text-[#1d3f89] font-semibold hover:text-[#8F1E98] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                        >
                            Contact
                        </a>

                        {/* Nouveau lien Boutique */}
                        {/* <a
                            href={routes?.boutique || "/boutique"}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="block py-2 px-3 text-[#1d3f89] font-semibold hover:text-[#8F1E98] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                        >
                            Calan'Boutique
                        </a> */}
                    </nav>

                    {/* CTA Desktop */}
                    <a
                        href={
                            routes?.billetterie ||
                            "{{ $currentEdition->reservation_url }}"
                        }
                        target="_blank"
                        rel="noopener noreferrer"
                        style={{
                            background:
                                "linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%)",
                        }}
                        className="hidden lg:inline-block text-white font-semibold px-6 py-2.5 rounded-lg hover:from-[#FF0F63] hover:to-[#8F1E98] transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#8F1E98] shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        aria-label="Acheter des billets (ouvre une nouvelle fenêtre)"
                    >
                        Acheter des billets{" "}
                        <span aria-hidden="true">
                            <i className="fa-solid fa-arrow-right fa-xs"></i>
                        </span>
                    </a>

                    {/* Menu Burger (Mobile) */}
                    <button
                        ref={btnRef}
                        type="button"
                        onClick={() => setIsOpen((open) => !open)}
                        className="p-1 text-[#1d3f89] focus:outline-none lg:hidden"
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
                        href={routes?.accueil || "/"}
                        ref={firstMobileLinkRef}
                        className="block py-2 font-semibold text-[#1d3f89]"
                    >
                        Accueil
                    </a>
                    {/* Infos Mobile */}
                    <div className="mb-4">
                        <h3 className="block py-2 font-semibold text-[#1d3f89]">
                            Infos
                        </h3>
                        <a
                            href="/camping"
                            className="block py-2 pl-4 text-gray-700 transition"
                        >
                            Camping & Hébergement
                        </a>
                        <a
                            href="/benevoles"
                            className="block py-2 pl-4 text-gray-700 transition"
                        >
                            Bénévoles
                        </a>
                    </div>
                    {/* Festival Mobile */}
                    <div className="mb-4">
                        <h3 className="block py-2 font-semibold text-[#1d3f89]">
                            Festival
                        </h3>
                        {/* <a
                            href="/news"
                            className="block py-2 pl-4 text-gray-700 hover:text-[#8F1E98] transition"
                        >
                            News & Actualités
                        </a> */}
                        <a
                            href="/charte"
                            className="block py-2 pl-4 text-gray-700 hover:text-[#8F1E98] transition"
                        >
                            Charte du festivalier
                        </a>
                        <a
                            href={routes?.festival || "/notre-histoire"}
                            className="block py-2 pl-4 text-gray-700 hover:text-[#8F1E98] transition"
                        >
                            À propos
                        </a>
                        <a
                            href="/partenaires"
                            className="block py-2 pl-4 text-gray-700 hover:text-[#8F1E98] transition"
                        >
                            Nos partenaires
                        </a>

                        {routes?.news && (
                            <a
                                href={routes.news}
                                className="block py-2 pl-4 text-gray-700 hover:text-[#8F1E98] transition"
                            >
                                Actualités
                            </a>
                        )}

                        {routes?.programmation && (
                            <a
                                href={routes.programmation}
                                className="block py-2 pl-4 text-gray-700 hover:text-[#8F1E98] transition"
                            >
                                Programmation
                            </a>
                        )}
                    </div>
                    {/* Liens directs Mobile */}
                    {routes?.news && (
                        <a
                            href={routes.news}
                            className="block py-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition border-t border-gray-100"
                        >
                            Actualités
                        </a>
                    )}
                    {routes?.programmation && (
                        <a
                            href={routes.programmation || "/programmation"}
                            className="block py-2 font-semibold text-[#1d3f89]"
                        >
                            Programmation
                        </a>
                    )}
                    <a
                        href={routes?.contact || "/contact"}
                        className="block py-2 font-semibold text-[#1d3f89]"
                    >
                        Contact
                    </a>
                    {/* Boutique Mobile */}
                    {/* <a
                        href={routes?.boutique || "/boutique"}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="block py-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition"
                    >
                        Calan'Boutique
                    </a> */}
                    {/* CTA Mobile */}
                    <a
                        href={
                            routes?.billetterie ||
                            "{{ $currentEdition->reservation_url }}"
                        }
                        target="_blank"
                        rel="noopener noreferrer"
                        style={{
                            background:
                                "linear-gradient(135deg, #1d3f89 40%, #77cbf3 100%)",
                        }}
                        className="block py-3 mt-4 font-semibold text-center text-white transition-all duration-300 rounded-lg shadow-lg"
                        aria-label="Acheter des billets (ouvre une nouvelle fenêtre)"
                    >
                        Acheter des billets{" "}
                        <span aria-hidden="true">
                            <i className="fa-solid fa-arrow-right fa-xs"></i>
                        </span>
                    </a>
                </nav>
            </div>
        </header>
    );
}
