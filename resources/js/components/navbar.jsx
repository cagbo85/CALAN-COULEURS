import { useState } from "react";

export default function Navbar() {
    const [isOpen, setIsOpen] = useState(false);

    return (
        <header className="bg-white shadow-md">
            <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center py-4">
                    {/* Logo */}
                    <a href="/" className="text-3xl font-bold text-[#8F1E98]">
                        CALAN <span className="text-[#FF0F63]">COULEURS</span>
                    </a>

                    {/* Menu Desktop */}
                    <nav className="hidden md:flex">
                        <a href="#" className="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition">Le Festival</a>
                        <a href="#" className="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition">Billetterie</a>
                        <a href="#" className="block py-2 px-3 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition">À Propos</a>
                    </nav>

                    {/* CTA */}
                    <a href="#" className="hidden md:inline-block bg-[#8F1E98] text-white font-semibold px-5 py-2 rounded-lg hover:bg-[#FF0F63] transition">
                        Acheter des billets →
                    </a>

                    {/* Menu Burger (Mobile) */}
                    <button onClick={() => setIsOpen(!isOpen)} className="md:hidden text-[#8F1E98] focus:outline-none">
                        <svg className="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
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
            <div className={`md:hidden transition-all duration-300 ${isOpen ? "max-h-screen opacity-100 visible" : "max-h-0 opacity-0 invisible"} overflow-hidden`}>
                <nav className="bg-white shadow-md py-4">
                    <a href="#" className="block text-center py-2 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition">Le Festival</a>
                    <a href="#" className="block text-center py-2 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition">Billetterie</a>
                    <a href="#" className="block text-center py-2 text-[#8F1E98] font-semibold hover:text-[#FF0F63] transition">À Propos</a>
                    <a href="#" className="block text-center mt-2 bg-[#8F1E98] text-white font-semibold mx-6 py-2 rounded-lg hover:bg-[#FF0F63] transition">
                        Acheter des billets →
                    </a>
                </nav>
            </div>
        </header>
    );
}
