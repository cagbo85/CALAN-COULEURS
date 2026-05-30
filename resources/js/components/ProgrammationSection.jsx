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
            <section className="px-6 py-16" style={{ backgroundColor: "#EEF1FF" }}>
                <div className="container mx-auto text-center">
                    <div className="mb-4 text-5xl drop-shadow-lg">⏳</div>
                    <p
                        className="text-lg font-semibold text-[#272AC7]"
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
            <section className="px-6 py-16" style={{ backgroundColor: "#EEF1FF" }}>
                <div className="container mx-auto text-center">
                    <BiSolidError className="mx-auto mb-4 text-5xl text-red-400" />
                    <p className="text-lg font-semibold text-[#272AC7]">{error}</p>
                </div>
            </section>
        );
    }

    // Etat vide (artistes non encore annoncés)
    if (!artists || artists.length === 0) {
        return (
            <section
                className="px-6 py-16"
                style={{ backgroundColor: "#EEF1FF" }}
                aria-labelledby="programmation-heading"
            >
                <div className="container mx-auto">
                    <h2
                        id="programmation-heading"
                        className="mb-12 text-4xl font-bold text-left uppercase drop-shadow-lg"
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
                        <article className="overflow-hidden border-2 shadow-xl bg-white/95 backdrop-blur-sm rounded-xl border-white/50">
                            <div
                                className="p-8 text-white"
                                style={{
                                    background:
                                        "linear-gradient(to right, #FF0F63, #8F1E98)",
                                }}
                            >
                                <h3 className="text-3xl font-bold tracking-wide text-center uppercase sm:text-left">
                                    🎵 Ça se prépare !
                                </h3>
                            </div>

                            <div className="p-8 text-center">
                                <p className="mb-4 text-lg leading-relaxed text-gray-700">
                                    La programmation de cette édition est
                                    actuellement en cours de finalisation.
                                </p>
                                <p className="mb-6 text-base text-gray-600">
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
            className="px-6 py-16"
            style={{ backgroundColor: "#EEF1FF" }}
            aria-labelledby="programmation-heading"
        >
            <div className="container mx-auto">
                <h2
                    id="programmation-heading"
                    className="text-4xl font-bold uppercase mb-12 text-left drop-shadow-lg text-[#272AC7]"
                >
                    Programmation
                </h2>

                <div className="grid max-w-6xl grid-cols-1 gap-6 mx-auto md:grid-cols-2">
                    {artists.map((day, index) => (
                        <article
                            key={index}
                            className="overflow-hidden transition-all duration-300 transform border-2 shadow-xl bg-white/95 backdrop-blur-sm rounded-xl hover:shadow-2xl hover:-translate-y-1 border-white/50"
                        >
                            {/* Header du jour */}
                            <div
                                className="p-6 text-white"
                                style={{ background: "linear-gradient(to right, #272AC7, #8F1E98)" }}
                            >
                                <h3 className="text-2xl font-bold tracking-wide uppercase">
                                    {day.jour_rep}
                                </h3>
                                <p className="mt-2 text-sm font-semibold text-white/90">
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

                <div className="mt-12 text-center">
                    <a
                        href="/programmation"
                        className="inline-block text-white font-semibold px-6 py-2.5 rounded-lg transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#272AC7] shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 bg-[#272AC7] hover:bg-[#8F1E98]"
                        style={{
                            background:
                                "linear-gradient(90deg, #272ac7 0%, #8f1e98 100%)",
                        }}
                    >
                        Voir toute la programmation
                    </a>
                </div>
            </div>
        </section>
    );
}
