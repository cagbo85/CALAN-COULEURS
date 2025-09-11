import React, { useState, useEffect } from 'react';

export default function PartnersSection() {
    const [partners, setPartners] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetch('/api/partenaires')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors du chargement des partenaires');
                }
                return response.json();
            })
            .then(data => {
                setPartners(data);
                setLoading(false);
            })
            .catch(err => {
                setError(err.message);
                setLoading(false);
            });
    }, []);

    // Fonction pour formater l'adresse complète
    const getFullAddress = (partner) => {
        const parts = [
            partner.adresse,
            partner.code_postal,
            partner.ville,
            partner.pays
        ].filter(Boolean);
        return parts.join(', ');
    };

    if (loading) {
        return (
            <section className="py-16 px-6 bg-gray-50">
                <div className="container mx-auto text-center">
                    <div className="animate-pulse">
                        <div className="h-8 bg-gray-300 rounded w-80 mx-auto mb-12"></div>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {[...Array(6)].map((_, i) => (
                                <div key={i} className="bg-white rounded-xl p-6 shadow-md">
                                    <div className="h-32 bg-gray-200 rounded mb-4"></div>
                                    <div className="h-4 bg-gray-200 rounded mb-2"></div>
                                    <div className="h-3 bg-gray-200 rounded mb-4"></div>
                                    <div className="h-3 bg-gray-200 rounded"></div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </section>
        );
    }

    if (error) {
        return (
            <section className="py-16 px-6 bg-gray-50">
                <div className="container mx-auto text-center">
                    <h2 className="text-3xl font-bold text-[#8F1E98] mb-4">Merci à nos partenaires</h2>
                    <p className="text-red-500">Erreur lors du chargement des partenaires: {error}</p>
                </div>
            </section>
        );
    }

    return (
        <section
            className="py-16 px-6 bg-gray-50"
            aria-labelledby="partners-heading"
            aria-describedby="partners-desc"
        >
            <div className="container mx-auto">
                <div className="text-center mb-12">
                    <h2
                        id="partners-heading"
                        className="text-4xl font-bold text-[#8F1E98] mb-4"
                    >
                        Merci à nos partenaires ❤️
                    </h2>
                    <p
                        id="partners-desc"
                        className="text-lg text-gray-600 max-w-2xl mx-auto"
                    >
                        Ils nous accompagnent et nous soutiennent pour faire de Calan'Couleurs une expérience unique !
                    </p>
                </div>

                {partners.length === 0 ? (
                    <div className="text-center py-8">
                        <p className="text-gray-500 text-lg">Aucun partenaire pour le moment.</p>
                    </div>
                ) : (
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {partners.map((partner) => {
                            const fullAddress = getFullAddress(partner);

                            return (
                                <div
                                    key={partner.id}
                                    className="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden"
                                >
                                    {/* Image ou logo */}
                                    <div
                                        className="h-48 relative overflow-hidden"
                                        style={{
                                            background: 'linear-gradient(135deg, #8F1E98 0%, #FF0F63 100%)'
                                        }}
                                    >
                                        {partner.photo || partner.logo ? (
                                            <img
                                                src={partner.photo || partner.logo}
                                                alt={`Logo de ${partner.name}`}
                                                className="w-full h-full object-cover"
                                            />
                                        ) : (
                                            <div className="flex items-center justify-center h-full">
                                                <div className="text-white text-6xl">🏢</div>
                                            </div>
                                        )}
                                    </div>

                                    {/* Contenu de la card */}
                                    <div className="p-6">
                                        {/* Nom du partenaire */}
                                        <h3 className="text-xl font-bold text-[#8F1E98] mb-3">
                                            {partner.name}
                                        </h3>

                                        {/* Description */}
                                        {partner.description && (
                                            <p className="text-gray-700 text-sm mb-4 leading-relaxed">
                                                {partner.description}
                                            </p>
                                        )}

                                        {/* Adresse */}
                                        {fullAddress && (
                                            <div className="flex items-start text-gray-600 text-sm mb-3">
                                                <svg className="w-4 h-4 text-[#FF0F63] mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fillRule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clipRule="evenodd" />
                                                </svg>
                                                <span>{fullAddress}</span>
                                            </div>
                                        )}

                                        {/* Téléphone */}
                                        {partner.phone && (
                                            <div className="flex items-center text-gray-600 text-sm mb-4">
                                                <svg className="w-4 h-4 text-[#FF0F63] mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                                </svg>
                                                <a
                                                    href={`tel:${partner.phone}`}
                                                    className="hover:text-[#8F1E98] transition-colors"
                                                >
                                                    {partner.phone}
                                                </a>
                                            </div>
                                        )}

                                        {/* Liens sociaux */}
                                        <div className="border-t border-gray-100 pt-4">
                                            <p className="text-sm font-semibold text-gray-700 mb-3">
                                                Retrouvez-les aussi sur :
                                            </p>
                                            <div className="flex gap-3 flex-wrap">
                                                {partner.site_url && (
                                                    <a
                                                        href={partner.site_url}
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        className="bg-[#8F1E98] text-white px-3 py-2 rounded-full text-xs font-medium hover:bg-[#FF0F63] transition-colors flex items-center gap-1"
                                                        aria-label={`Site web de ${partner.name}`}
                                                    >
                                                        <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fillRule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.559-.499-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.559.499.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.497-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clipRule="evenodd" />
                                                        </svg>
                                                        Site web
                                                    </a>
                                                )}
                                                {partner.instagram_url && (
                                                    <a
                                                        href={partner.instagram_url}
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        className="text-white px-3 py-2 rounded-full text-xs font-medium transition-colors flex items-center gap-1"
                                                        style={{
                                                            background: 'linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%)'
                                                        }}
                                                        aria-label={`Instagram de ${partner.name}`}
                                                    >
                                                        <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                                        </svg>
                                                        Instagram
                                                    </a>
                                                )}
                                                {partner.facebook_url && (
                                                    <a
                                                        href={partner.facebook_url}
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        className="bg-blue-600 text-white px-3 py-2 rounded-full text-xs font-medium hover:bg-blue-700 transition-colors flex items-center gap-1"
                                                        aria-label={`Facebook de ${partner.name}`}
                                                    >
                                                        <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                                        </svg>
                                                        Facebook
                                                    </a>
                                                )}
                                                {partner.linkedin_url && (
                                                    <a
                                                        href={partner.linkedin_url}
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        className="bg-blue-700 text-white px-3 py-2 rounded-full text-xs font-medium hover:bg-blue-800 transition-colors flex items-center gap-1"
                                                        aria-label={`LinkedIn de ${partner.name}`}
                                                    >
                                                        <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                                        </svg>
                                                        LinkedIn
                                                    </a>
                                                )}
                                                {partner.autre_url && (
                                                    <a
                                                        href={partner.autre_url}
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        className="bg-gray-600 text-white px-3 py-2 rounded-full text-xs font-medium hover:bg-gray-700 transition-colors flex items-center gap-1"
                                                        aria-label={`Autre lien de ${partner.name}`}
                                                    >
                                                        <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fillRule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clipRule="evenodd" />
                                                        </svg>
                                                        Autre
                                                    </a>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                )}
            </div>
        </section>
    );
}
