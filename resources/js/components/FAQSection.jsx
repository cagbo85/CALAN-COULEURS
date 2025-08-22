import React, { useState, useEffect } from "react";
import FAQItem from "./FAQItem";

export default function FAQSection() {
    const [faqs, setFaqs] = useState([]);
    const [loading, setLoading] = useState(true);
    const [loadError, setLoadError] = useState(null);

    // IDs pour l’accessibilité
    const sectionId = "faq";
    const headingId = `${sectionId}-heading`;
    const descId = `${sectionId}-desc`;
    const errorId = `${sectionId}-error`;

    useEffect(() => {
        const controller = new AbortController();

        async function fetchFaqs() {
            try {
                const response = await fetch("/api/faqs", {
                    signal: controller.signal,
                });
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }
                const data = await response.json();
                setFaqs(Array.isArray(data) ? data : []);
                setLoadError(null);
            } catch (error) {
                console.error("Erreur lors du chargement des FAQs:", error);
                setLoadError("Impossible de charger la FAQ pour le moment.");
                // Fallback accessible
                setFaqs([
                    {
                        id: "fallback-1",
                        question: "Où et quand se déroule le festival ?",
                        answer: "Rendez-vous à Campbon (44) les 12 & 13 septembre pour deux jours de musique.",
                    },
                    {
                        id: "fallback-2",
                        question: "À quelle heure ouvrent les portes ?",
                        answer: "Nous vous accueillons dès 19h le vendredi et 13h le samedi.",
                    },
                ]);
            } finally {
                setLoading(false);
            }
        }

        fetchFaqs();
        return () => controller.abort();
    }, []);

    if (loading) {
        return (
            <section
                className="py-16 px-6"
                style={{
                    background:
                        "linear-gradient(180deg, rgba(39,42,199,1) 0%, rgba(143,30,152,1) 35%, rgba(255,15,99,1) 100%)",
                }}
                aria-labelledby={headingId}
                aria-describedby={descId}
                aria-busy="true"
                role="region"
            >
                <div className="container mx-auto">
                    <h2
                        id={headingId}
                        className="text-white text-3xl font-bold uppercase mb-2"
                    >
                        Foire aux questions
                    </h2>
                    <p id={descId} className="sr-only">
                        Questions les plus fréquentes au sujet du festival
                        Calan’Couleurs.
                    </p>

                    <div
                        className="max-w-2xl mx-auto mt-8 text-white text-center"
                        role="status"
                        aria-live="polite"
                    >
                        Chargement des FAQs…
                    </div>
                </div>
            </section>
        );
    }

    return (
        <section
            className="py-16 px-6"
            style={{
                background:
                    "linear-gradient(180deg, rgba(39,42,199,1) 0%, rgba(143,30,152,1) 35%, rgba(255,15,99,1) 100%)",
            }}
            aria-labelledby={headingId}
            aria-describedby={loadError ? `${descId} ${errorId}` : descId}
            role="region"
        >
            <div className="container mx-auto">
                <h2
                    id={headingId}
                    className="text-white text-3xl font-bold uppercase mb-2"
                >
                    Foire aux questions
                </h2>
                <p id={descId} className="sr-only">
                    Questions fréquentes et réponses pratiques pour préparer
                    votre venue.
                </p>

                {/* Message d’erreur lisible lecteurs d’écran */}
                {loadError && (
                    <div
                        id={errorId}
                        className="max-w-2xl mx-auto mt-4 text-white bg-red-600/30 border border-red-500/50 rounded p-3"
                        role="alert"
                        aria-live="assertive"
                    >
                        {loadError}
                    </div>
                )}

                <div className="max-w-2xl mx-auto mt-6 space-y-4">
                    {faqs.length > 0 ? (
                        <ul
                            role="list"
                            aria-label="Liste des questions fréquentes"
                        >
                            {faqs.map((faq, idx) => {
                                // Prépare des IDs stables pour un pattern d’accordéon côté FAQItem
                                const itemId =
                                    typeof faq.id !== "undefined"
                                        ? faq.id
                                        : `faq-${idx}`;
                                const buttonId = `${itemId}-button`;
                                const panelId = `${itemId}-panel`;

                                return (
                                    <li
                                        key={itemId}
                                        role="listitem"
                                        className="mb-3"
                                    >
                                        <FAQItem
                                            idBase={itemId}
                                            buttonId={buttonId}
                                            panelId={panelId}
                                            question={faq.question}
                                            answer={faq.answer}
                                        />
                                    </li>
                                );
                            })}
                        </ul>
                    ) : (
                        <p className="text-white/90" role="note">
                            Aucune question pour le moment.
                        </p>
                    )}
                </div>
            </div>
        </section>
    );
}
