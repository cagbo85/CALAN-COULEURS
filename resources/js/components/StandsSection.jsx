import React, { useState, useEffect } from "react";
import OnSiteFeature from "./OnSiteFeature";
import { BiSolidError } from "react-icons/bi";

const toAccessibleTitle = (title) =>
    title.replace(/^[^\p{L}\p{N}]+/u, "").trim();

export default function StandsSection() {
    const [stands, setStands] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetch("/api/stands/current")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Impossible de charger les stands");
                }
                return response.json();
            })
            .then((data) => {
                setStands(data);
                setLoading(false);
            })
            .catch((err) => {
                setError(err.message);
                setLoading(false);
            });
    }, []);

    // Grouper les stands par type
    const standsByType = {
        autre: stands.filter((stand) => stand.type === "autre"),
        boutique: stands.filter((stand) => stand.type === "boutique"),
        foodtruck: stands.filter((stand) => stand.type === "foodtruck"),
        tatouage: stands.filter((stand) => stand.type === "tatouage"),
    };

    const typeLabels = {
        autre: "Nos stands",
        boutique: "Friperie & Boutique",
        foodtruck: "Food Trucks",
        tatouage: "Stand Tatouage",
    };

    const getPrimaryLink = (stand) => {
        if (stand.website_url) return stand.website_url;
        if (stand.instagram_url) return stand.instagram_url;
        if (stand.facebook_url) return stand.facebook_url;
        if (stand.other_link) return stand.other_link;
        return null;
    };

    // Etat de chargement
    if (loading) {
        return (
            <section className="pb-16 px-6 bg-gray-100">
                <div className="container mx-auto text-center">
                    <div className="text-5xl mb-4 drop-shadow-lg">⏳</div>
                    <p
                        className="text-white text-lg font-semibold"
                        style={{
                            background:
                                "linear-gradient(to right, #FF0F63, #8F1E98)",
                            WebkitBackgroundClip: "text",
                            WebkitTextFillColor: "transparent",
                            backgroundClip: "text",
                        }}
                    >
                        Chargement des stands...
                    </p>
                </div>
            </section>
        );
    }

    // Etat d'erreur
    if (error) {
        return (
            <section
                className="py-16 px-6 bg-gray-100"
                style={{
                    background:
                        "linear-gradient(180deg, rgba(39,42,199,1) 0%, rgba(143,30,152,1) 35%, rgba(255,15,99,1) 100%)",
                }}
                aria-labelledby="stands-heading"
            >
                <div className="container mx-auto text-center">
                    <BiSolidError className="text-5xl mb-4 text-red-400 mx-auto" />
                    <p className="text-white text-lg font-semibold">{error}</p>
                </div>
            </section>
        );
    }

    // Etat vide (stands non encore annoncés)
    if (!stands || stands.length === 0) {
        return (
            <section
                className="py-16 px-6 bg-gray-100"
                aria-labelledby="stands-heading"
            >
                <div className="container mx-auto">
                    <h2
                        id="stands-heading"
                        className="text-4xl font-bold uppercase mb-12 text-left drop-shadow-lg"
                        style={{
                            background:
                                "linear-gradient(180deg, rgba(39,42,199,1) 0%, rgba(143,30,152,1) 35%, rgba(255,15,99,1) 100%)",
                            WebkitBackgroundClip: "text",
                            WebkitTextFillColor: "transparent",
                            backgroundClip: "text",
                        }}
                    >
                        Sur Place
                    </h2>

                    <div className="max-w-2xl mx-auto">
                        <article className="bg-white/95 backdrop-blur-sm rounded-xl shadow-xl overflow-hidden border-2 border-white/50">
                            <div
                                className="p-8 text-white"
                                style={{
                                    background:
                                        "linear-gradient(to right, #FF0F63, #8F1E98)",
                                }}
                            >
                                <h3 className="text-center sm:text-left text-3xl font-bold uppercase tracking-wide">
                                    🍔 Ça mijote !
                                </h3>
                            </div>

                            <div className="p-8 text-center">
                                <p className="text-lg text-gray-700 mb-4 leading-relaxed">
                                    Les stands et food trucks sont en cours de
                                    sélection pour cette édition.
                                </p>
                                <p className="text-base text-gray-600 mb-6">
                                    Bientôt, vous découvrirez tous nos
                                    partenaires sur place : restauration,
                                    boutiques, tatouages et bien plus ! 🎪
                                </p>

                                <div className="flex justify-center gap-2 mb-6">
                                    <div className="w-2 h-2 bg-[#FF0F63] rounded-full animate-bounce"></div>
                                    <div
                                        className="w-2 h-2 bg-[#8F1E98] rounded-full animate-bounce"
                                        style={{ animationDelay: "0.1s" }}
                                    ></div>
                                    <div
                                        className="w-2 h-2 bg-[#272AC7] rounded-full animate-bounce"
                                        style={{ animationDelay: "0.2s" }}
                                    ></div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        );
    }

    // Etat normal (stands disponibles)
    return (
        <section
            className="py-16 px-6 bg-gray-100"
            aria-labelledby="stands-heading"
        >
            <div className="container mx-auto">
                <h2
                    id="stands-heading"
                    className="text-4xl font-bold uppercase mb-12 text-left drop-shadow-lg"
                    style={{
                        background:
                            "linear-gradient(180deg, rgba(39,42,199,1) 0%, rgba(143,30,152,1) 35%, rgba(255,15,99,1) 100%)",
                        WebkitBackgroundClip: "text",
                        WebkitTextFillColor: "transparent",
                        backgroundClip: "text",
                    }}
                >
                    Sur Place
                </h2>

                <p id="stands-desc" className="sr-only">
                    Informations sur les stands du festival et les food trucks
                    disponibles sur le site.
                </p>

                {Object.entries(standsByType).map(([type, typeStands]) => {
                    if (typeStands.length === 0) return null;

                    return (
                        <div key={type} className="mb-16">
                            <h3 className="text-2xl font-semibold xl:pl-32 mb-6 xl:text-left text-center drop-shadow-md text-[#FF0F63]">
                                {typeLabels[type]}
                            </h3>

                            <ul
                                role="list"
                                className="flex flex-wrap justify-center gap-6"
                                aria-label={`Liste des ${typeLabels[type].toLowerCase()} présents au festival`}
                            >
                                {typeStands.map((stand) => {
                                    const primaryLink = getPrimaryLink(stand);
                                    const accessibleTitle = toAccessibleTitle(
                                        stand.name,
                                    );

                                    return (
                                        <li
                                            key={stand.id}
                                            role="listitem"
                                            className="w-full sm:w-80"
                                        >
                                            <OnSiteFeature
                                                title={stand.name}
                                                description={stand.description}
                                                imageSrc={
                                                    stand.photo ||
                                                    "/img/default-stand.jpg"
                                                }
                                                imageAlt={`${accessibleTitle} — ${typeLabels[type].toLowerCase()}`}
                                                website={primaryLink}
                                                websiteLabel={
                                                    stand.name.includes(
                                                        "Calan'Boutique",
                                                    )
                                                        ? "Visiter notre boutique →"
                                                        : "Visiter leur site →"
                                                }
                                            />
                                        </li>
                                    );
                                })}
                            </ul>
                        </div>
                    );
                })}
            </div>
        </section>
    );
}
