import { useState, useEffect } from "react";
import { BiSolidError } from "react-icons/bi";

export default function ProgrammationCurrent() {
    const [edition, setEdition] = useState(null);
    const [artists, setArtists] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetch("/api/artists/current")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Impossible de charger la programmation");
                }
                return response.json();
            })
            .then((data) => {
                setEdition(data.edition);
                setArtists(data.artists);
                setLoading(false);
            })
            .catch((err) => {
                setError(err.message);
                setLoading(false);
            });
    }, []);

    // Etat de chargement
    if (loading) {
        return (
            <section className="py-16 px-6 bg-gray-100">
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
                        Chargement de la programmation...
                    </p>
                </div>
            </section>
        );
    }

    // Etat d'erreur
    if (error) {
        return (
            <section className="py-16 px-6 bg-gray-100">
                <div className="container mx-auto text-center">
                    <BiSolidError className="text-5xl mb-4 text-red-400 mx-auto" />
                    <p className="text-white text-lg font-semibold">{error}</p>
                </div>
            </section>
        );
    }

    // Etat vide (artistes non encore annoncés)
    if (!artists || artists.length === 0) {
        return (
            <section
                className="py-16 px-6 bg-gray-100"
                aria-labelledby="programmation-heading"
            >
                <div className="container mx-auto">
                    <h2
                        id="programmation-heading"
                        className="text-4xl font-bold uppercase mb-12 text-left drop-shadow-lg"
                        style={{
                            background:
                                "linear-gradient(180deg, rgba(39,42,199,1) 0%, rgba(143,30,152,1) 35%, rgba(255,15,99,1) 100%)",
                            WebkitBackgroundClip: "text",
                            WebkitTextFillColor: "transparent",
                            backgroundClip: "text",
                        }}
                    >
                        Programmation
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
                                    🎵 Ça se prépare !
                                </h3>
                            </div>

                            <div className="p-8 text-center">
                                <p className="text-lg text-gray-700 mb-4 leading-relaxed">
                                    La programmation de cette édition est
                                    actuellement en cours de finalisation.
                                </p>
                                <p className="text-base text-gray-600 mb-6">
                                    Restez connectés pour découvrir les artistes
                                    et les surprises qui vous attendent ! 🎶
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

    // Etat normal (programmation disponible)
    return (
        <section
            className="py-16 px-6 bg-gray-100"
            aria-labelledby="programmation-heading"
        >
            <div className="container mx-auto">
                <h2
                    id="programmation-heading"
                    className="text-4xl font-bold uppercase mb-12 text-left drop-shadow-lg"
                    style={{
                        background:
                            "linear-gradient(180deg, rgba(39,42,199,1) 0%, rgba(143,30,152,1) 35%, rgba(255,15,99,1) 100%)",
                        WebkitBackgroundClip: "text",
                        WebkitTextFillColor: "transparent",
                        backgroundClip: "text",
                    }}
                >
                    Programmation
                </h2>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-6xl mx-auto">
                    {artists.map((day, index) => (
                        <article
                            key={index}
                            className="bg-white/95 backdrop-blur-sm rounded-xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border-2 border-white/50"
                        >
                            {/* Header du jour */}
                            <div
                                className="p-6 text-white"
                                style={{
                                    background:
                                        "linear-gradient(to right, #FF0F63, #8F1E98)",
                                }}
                            >
                                <h3 className="text-2xl font-bold uppercase tracking-wide">
                                    {day.jour_rep}
                                </h3>
                                <p className="text-sm font-semibold text-white/90 mt-2">
                                    <time>{day.heu_min}</time>
                                    {" - "}
                                    <time>{day.heu_max}</time>
                                </p>
                            </div>

                            {/* Liste des artistes */}
                            <div className="p-6">
                                <ul
                                    className="space-y-3"
                                    aria-label={`Artistes du ${day.jour_rep}`}
                                >
                                    {day.artistes
                                        .split(", ")
                                        .map((artist, idx) => (
                                            <li
                                                key={idx}
                                                className="text-lg font-bold text-[#8F1E98] uppercase tracking-wide border-b border-gray-200 pb-3 last:border-b-0"
                                            >
                                                🎵 {artist}
                                            </li>
                                        ))}
                                </ul>
                            </div>
                        </article>
                    ))}
                </div>

                <div className="text-center mt-12">
                    <a
                        href="/programmation"
                        className="inline-block text-white font-semibold px-6 py-2.5 rounded-lg hover:from-[#FF0F63] hover:to-[#8F1E98] transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#8F1E98] shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        style={{
                            background:
                                "linear-gradient(180deg, rgba(255,15,99,0.9) 0%, rgba(143,30,152,0.9) 35%, rgba(39,42,199,0.9) 100%)",
                        }}
                    >
                        Voir toute la programmation
                    </a>
                </div>
            </div>
        </section>
    );
}
