import { useEffect, useRef, useState } from "react";

export default function Navbar({ routes }) {
    const [isOpen, setIsOpen] = useState(false);
    const btnRef = useRef(null);
    const firstMobileLinkRef = useRef(null);

    useEffect(() => {
        function onKeyDown(e) {
            if (e.key === "Escape" && isOpen) {
                setIsOpen(false);
                btnRef.current?.focus();
            }
        }
        window.addEventListener("keydown", onKeyDown);
        return () => window.removeEventListener("keydown", onKeyDown);
    }, [isOpen]);

    useEffect(() => {
        if (isOpen) {
            firstMobileLinkRef.current?.focus();
        }
    }, [isOpen]);

    return (
        <header className="bg-white shadow-md">
            <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center py-4">
                    {/* Logo */}
                    <a
                        href={routes?.home || "/"}
                        className="flex items-center"
                        aria-label="Aller à l’accueil"
                    >
                        <img
                            src="/img/logos/LOGO/Logo-Calan.png"
                            alt="Calan’Couleurs"
                            className="h-12"
                        />
                    </a>

                    {/* Menu Desktop */}
                    <nav
                        className="hidden md:flex"
                        aria-label="Navigation principale"
                    >
                        <a
                            href={routes?.home || "/"}
                            className="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98]"
                        >
                            Le festival
                        </a>
                        <a
                            href={routes?.festival || "/notre-histoire"}
                            className="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98]"
                        >
                            Notre histoire
                        </a>
                        {/* <a
                            href={routes?.programmation || "/programmation"}
                            className="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98]"
                        >
                            Programmation
                        </a> */}
                        {/* <a
                            href={
                                routes?.billetterie ||
                                "https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs"
                            }
                            target="_blank"
                            rel="noopener noreferrer"
                            className="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98]"
                        >
                            Billetterie
                        </a> */}
                        <a
                            href={routes?.contact || "/contact"}
                            className="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98]"
                        >
                            Contact
                        </a>
                        {/* <a href="" className="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition">À Propos</a> */}
                    </nav>

                    {/* CTA */}
                    <a
                        href={
                            routes?.billetterie ||
                            "https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs"
                        }
                        target="_blank"
                        rel="noopener noreferrer"
                        className="hidden md:inline-block bg-[#8F1E98] text-white font-semibold px-5 py-2 rounded-lg hover:bg-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#8F1E98]"
                        aria-label="Acheter des billets (ouvre une nouvelle fenêtre)"
                    >
                        Acheter des billets <span aria-hidden="true">→</span>
                    </a>

                    {/* Menu Burger (Mobile) */}
                    <button
                        ref={btnRef}
                        onClick={() => setIsOpen(!isOpen)}
                        className="md:hidden text-[#8F1E98] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98] rounded"
                        aria-controls="mobile-menu"
                        aria-expanded={isOpen}
                        aria-label={
                            isOpen ? "Fermer le menu" : "Ouvrir le menu"
                        }
                    >
                        <svg
                            className="w-8 h-8"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            strokeWidth="2"
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            aria-hidden="true"
                            focusable="false"
                        >
                            {isOpen ? (
                                <path d="M6 18L18 6M6 6l12 12" /> // Croix quand ouvert
                            ) : (
                                <path d="M4 6h16M4 12h16M4 18h16" /> // Trois barres quand fermé
                            )}
                        </svg>
                    </button>
                </div>
            </div>

            {/* ✅ Menu Mobile (juste en-dessous de la navbar) */}
            <div
                id="mobile-menu"
                className={`md:hidden transition-all duration-300 motion-reduce:transition-none ${
                    isOpen
                        ? "max-h-screen opacity-100 visible"
                        : "max-h-0 opacity-0 invisible"
                } overflow-hidden`}
                hidden={!isOpen} // retiré de l’arbre a11y quand fermé
                aria-label="Navigation principale mobile"
            >
                <nav className="bg-white shadow-md py-4">
                    <a
                        href={routes?.festival || "/notre-histoire"}
                        className="block text-center py-2 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98]"
                    >
                        Le Festival
                    </a>
                    {/* <a
                        href={routes?.programmation || "/programmation"}
                        className="block text-center py-2 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98]"
                    >
                        Programmation
                    </a> */}
                    <a
                        href={
                            routes?.billetterie ||
                            "https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs"
                        }
                        target="_blank"
                        rel="noopener noreferrer"
                        className="block text-center py-2 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98]"
                    >
                        Billetterie
                    </a>
                    <a
                        href={routes?.contact || "/contact"}
                        className="block text-center py-2 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#8F1E98]"
                    >
                        Contact
                    </a>
                    {/* <a href="#" className="block text-center py-2 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition">À Propos</a> */}
                    <a
                        href={
                            routes?.billetterie ||
                            "https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs"
                        }
                        target="_blank"
                        rel="noopener noreferrer"
                        className="block text-center mt-2 bg-[#8F1E98] text-white font-semibold mx-6 py-2 rounded-lg hover:bg-[#FF0F63] transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#8F1E98]"
                        aria-label="Acheter des billets (ouvre une nouvelle fenêtre)"
                    >
                        Acheter des billets →
                    </a>
                </nav>
            </div>
        </header>
    );
}
