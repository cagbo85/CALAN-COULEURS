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
            activeDropdown === dropdownName ? null : dropdownName
        );
    };

    return (
        <header className="bg-white shadow-md relative z-50">
            <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center py-4">
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
                        className="hidden lg:flex items-center space-x-1"
                        aria-label="Navigation principale"
                    >
                        {/* Infos Dropdown */}
                        <div className="dropdown-container relative">
                            <button
                                onClick={() => toggleDropdown("infos")}
                                className="flex items-center py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                                aria-expanded={activeDropdown === "infos"}
                                aria-haspopup="true"
                            >
                                Infos
                                <svg
                                    className={`ml-1 w-4 h-4 transition-transform ${
                                        activeDropdown === "infos"
                                            ? "rotate-180"
                                            : ""
                                    }`}
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fillRule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clipRule="evenodd"
                                    />
                                </svg>
                            </button>

                            {activeDropdown === "infos" && (
                                <div className="absolute top-full left-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-2">
                                    {/* <a
                                        href="/camping"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#8F1E98] transition"
                                    >
                                        Camping & Hébergement
                                    </a> */}
                                    <a
                                        href="/benevoles"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#8F1E98] transition"
                                    >
                                        Bénévoles
                                    </a>
                                </div>
                            )}
                        </div>

                        {/* Festival Dropdown */}
                        <div className="dropdown-container relative">
                            <button
                                onClick={() => toggleDropdown("festival")}
                                className="flex items-center py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                                aria-expanded={activeDropdown === "festival"}
                                aria-haspopup="true"
                            >
                                Festival
                                <svg
                                    className={`ml-1 w-4 h-4 transition-transform ${
                                        activeDropdown === "festival"
                                            ? "rotate-180"
                                            : ""
                                    }`}
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fillRule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clipRule="evenodd"
                                    />
                                </svg>
                            </button>

                            {activeDropdown === "festival" && (
                                <div className="absolute top-full left-0 mt-1 w-52 bg-white rounded-lg shadow-lg border border-gray-100 py-2">
                                    <a
                                        href="/news"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#8F1E98] transition"
                                    >
                                        News & Actualités
                                    </a>
                                    <a
                                        href="/charte"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#8F1E98] transition"
                                    >
                                        Charte du festivalier
                                    </a>
                                    <a
                                        href={
                                            routes?.festival ||
                                            "/notre-histoire"
                                        }
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#8F1E98] transition"
                                    >
                                        À propos
                                    </a>
                                    <a
                                        href="/partenaires"
                                        className="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-[#8F1E98] transition"
                                    >
                                        Partenaires
                                    </a>
                                </div>
                            )}
                        </div>

                        {/* Liens simples */}
                        <a
                            href={routes?.programmation || "/programmation"}
                            className="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                        >
                            Programmation
                        </a>

                        <a
                            href={routes?.contact || "/contact"}
                            className="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                        >
                            Contact
                        </a>
                    </nav>

                    {/* CTA Desktop */}
                    <a
                        href={
                            routes?.billetterie ||
                            "https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs"
                        }
                        target="_blank"
                        rel="noopener noreferrer"
                        style={{
                            background:
                                "linear-gradient(180deg, rgba(255,15,99,0.9) 0%, rgba(143,30,152,0.9) 35%, rgba(39,42,199,0.9) 100%)",
                        }}
                        className="hidden lg:inline-block text-white font-semibold px-6 py-2.5 rounded-lg hover:from-[#FF0F63] hover:to-[#8F1E98] transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#8F1E98] shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        aria-label="Acheter des billets (ouvre une nouvelle fenêtre)"
                    >
                        Acheter des billets <span aria-hidden="true">→</span>
                    </a>

                    {/* Menu Burger (Mobile) */}
                    <button
                        ref={btnRef}
                        onClick={() => setIsOpen(!isOpen)}
                        className="lg:hidden text-[#8F1E98] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded p-2"
                        aria-controls="mobile-menu"
                        aria-expanded={isOpen}
                        aria-label={
                            isOpen ? "Fermer le menu" : "Ouvrir le menu"
                        }
                    >
                        <svg
                            className="w-6 h-6"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            strokeWidth="2"
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            aria-hidden="true"
                        >
                            {isOpen ? (
                                <path d="M6 18L18 6M6 6l12 12" />
                            ) : (
                                <path d="M4 6h16M4 12h16M4 18h16" />
                            )}
                        </svg>
                    </button>
                </div>
            </div>

            {/* Menu Mobile */}
            <div
                id="mobile-menu"
                className={`lg:hidden transition-all duration-300 motion-reduce:transition-none ${
                    isOpen
                        ? "max-h-screen opacity-100 visible"
                        : "max-h-0 opacity-0 invisible"
                } overflow-hidden`}
                hidden={!isOpen}
                aria-label="Navigation principale mobile"
            >
                <nav className="bg-white border-t border-gray-100 py-4 px-4">
                    {/* Infos Mobile */}
                    <div className="mb-4">
                        <h3 className="text-[#8F1E98] font-bold text-sm uppercase tracking-wide mb-2">
                            Infos
                        </h3>
                        {/* <a
                            href="/camping"
                            className="block py-2 pl-4 text-gray-700 hover:text-[#8F1E98] transition"
                        >
                            Camping & Hébergement
                        </a> */}
                        <a
                            href="/benevoles"
                            className="block py-2 pl-4 text-gray-700 hover:text-[#8F1E98] transition"
                        >
                            Bénévoles
                        </a>
                    </div>

                    {/* Festival Mobile */}
                    <div className="mb-4">
                        <h3 className="text-[#8F1E98] font-bold text-sm uppercase tracking-wide mb-2">
                            Festival
                        </h3>
                        <a
                            href="/news"
                            className="block py-2 pl-4 text-gray-700 hover:text-[#8F1E98] transition"
                        >
                            News & Actualités
                        </a>
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
                            Partenaires
                        </a>
                    </div>

                    {/* Liens directs Mobile */}
                    <a
                        href={routes?.programmation || "/programmation"}
                        className="block py-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition border-t border-gray-100"
                    >
                        Programmation
                    </a>
                    <a
                        href={routes?.contact || "/contact"}
                        className="block py-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition"
                    >
                        Contact
                    </a>

                    {/* CTA Mobile */}
                    <a
                        href={
                            routes?.billetterie ||
                            "https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs"
                        }
                        target="_blank"
                        rel="noopener noreferrer"
                        style={{
                            background:
                                "linear-gradient(180deg, rgba(255,15,99,0.9) 0%, rgba(143,30,152,0.9) 35%, rgba(39,42,199,0.9) 100%)",
                        }}
                        className="block text-center mt-4 text-white font-semibold py-3 rounded-lg hover:from-[#FF0F63] hover:to-[#8F1E98] transition-all duration-300 shadow-lg"
                        aria-label="Acheter des billets (ouvre une nouvelle fenêtre)"
                    >
                        Acheter des billets <span aria-hidden="true">→</span>
                    </a>
                </nav>
            </div>
        </header>
    );
}
