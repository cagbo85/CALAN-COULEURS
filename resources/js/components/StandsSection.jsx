import React, { useState, useEffect } from 'react';
import OnSiteFeature from './OnSiteFeature';

const toAccessibleTitle = (title) => title.replace(/^[^\p{L}\p{N}]+/u, '').trim();

export default function StandsSection() {
    const [stands, setStands] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetch('/api/stands')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors du chargement des stands');
                }
                return response.json();
            })
            .then(data => {
                setStands(data);
                setLoading(false);
            })
            .catch(err => {
                setError(err.message);
                setLoading(false);
            });
    }, []);

    // Grouper les stands par type
    const standsByType = {
        autre: stands.filter(stand => stand.type === 'autre'),
        boutique: stands.filter(stand => stand.type === 'boutique'),
        foodtruck: stands.filter(stand => stand.type === 'foodtruck'),
        tatouage: stands.filter(stand => stand.type === 'tatouage'),
    };

    const typeLabels = {
        autre: 'Nos stands',
        boutique: 'Friperie & Boutique',
        foodtruck: 'Food Trucks',
        tatouage: 'Stand Tatouage',
    };

    const typeIcons = {
        autre: '🛟',
        boutique: '👚🛍️',
        foodtruck: '🍔',
        tatouage: '🖋',
    };

    // Fonction pour obtenir le lien prioritaire (website > instagram > facebook > other)
    const getPrimaryLink = (stand) => {
        if (stand.website_url) return stand.website_url;
        if (stand.instagram_url) return stand.instagram_url;
        if (stand.facebook_url) return stand.facebook_url;
        if (stand.other_link) return stand.other_link;
        return null;
    };

    // Fonction pour formater le titre avec l'icône
    const formatTitle = (stand, typeIcon) => {
        // Pour les stands de type "autre", on garde le nom tel quel
        if (stand.type === 'autre') {
            return `${typeIcon} ${stand.name}`;
        }
        // Pour les autres types, on peut personnaliser
        if (stand.type === 'boutique') {
            return stand.name === "Calan'Boutique"
                ? `${typeIcon} Friperie & Boutique Calan'Couleurs`
                : stand.name;
        }
        return stand.name;
    };

    if (loading) {
        return (
            <section className="py-12 px-6 bg-white" aria-labelledby="stands-heading">
                <div className="container mx-auto text-center">
                    <div className="animate-pulse">
                        <div className="h-8 bg-gray-300 rounded w-64 mx-auto mb-8"></div>
                        <div className="flex flex-wrap justify-center gap-8">
                            {[...Array(6)].map((_, i) => (
                                <div key={i} className="w-80 h-96 bg-gray-200 rounded"></div>
                            ))}
                        </div>
                    </div>
                </div>
            </section>
        );
    }

    if (error) {
        return (
            <section className="py-12 px-6 bg-white" aria-labelledby="stands-heading">
                <div className="container mx-auto text-center">
                    <h2 className="text-[#8F1E98] text-3xl font-bold mb-4">Sur place</h2>
                    <p className="text-red-500">Erreur lors du chargement des stands: {error}</p>
                </div>
            </section>
        );
    }

    return (
        <section
            className="py-12 px-6 bg-white"
            aria-labelledby="stands-heading"
            aria-describedby="stands-desc"
        >
            <div className="container mx-auto">
                <h2
                    id="stands-heading"
                    className="text-[#8F1E98] text-3xl font-bold uppercase mb-2 text-center md:text-left"
                >
                    Sur place
                </h2>
                <p id="stands-desc" className="sr-only">
                    Informations sur les stands du festival et les food trucks disponibles sur le site.
                </p>

                {Object.entries(standsByType).map(([type, typeStands]) => {
                    if (typeStands.length === 0) return null;

                    return (
                        <div key={type} className="mb-16">
                            <h3 className="text-[#FF0F63] text-2xl font-semibold mb-6 ml-4 text-center md:text-left">
                                {typeLabels[type]}
                            </h3>

                            <ul
                                role="list"
                                className={`flex flex-wrap justify-center gap-54`}
                                aria-label={`Liste des ${typeLabels[type].toLowerCase()} présents au festival`}
                            >
                                {typeStands.map((stand) => {
                                    const primaryLink = getPrimaryLink(stand);
                                    const accessibleTitle = toAccessibleTitle(stand.name);
                                    const formattedTitle = formatTitle(stand, typeIcons[type]);

                                    return (
                                        <li
                                            key={stand.id}
                                            role="listitem"
                                            className="w-full sm:w-80"
                                        >
                                            <OnSiteFeature
                                                title={formattedTitle}
                                                description={stand.description}
                                                imageSrc={stand.photo || '/img/default-stand.jpg'}
                                                imageAlt={`${accessibleTitle} — ${typeLabels[type].toLowerCase()}`}
                                                website={primaryLink}
                                                websiteLabel={primaryLink ? `${accessibleTitle} — voir plus (nouvelle fenêtre)` : null}
                                            />
                                        </li>
                                    );
                                })}
                            </ul>
                        </div>
                    );
                })}

                {stands.length === 0 && (
                    <div className="text-center py-8">
                        <p className="text-gray-500 text-lg">Aucun stand pour le moment. Revenez bientôt !</p>
                    </div>
                )}
            </div>
        </section>
    );
}
