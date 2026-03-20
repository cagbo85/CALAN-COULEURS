import { useState, useEffect } from "react";
import FAQItem from "./FAQItem";
import { BiSolidError } from "react-icons/bi";

export default function FAQSection() {
    const [faqs, setFaqs] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    // IDs pour l’accessibilité
    const sectionId = "faq";
    const headingId = `${sectionId}-heading`;
    const descId = `${sectionId}-desc`;
    const errorId = `${sectionId}-error`;

    useEffect(() => {
        fetch("/api/faqs")
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Impossible de charger la FAQ");
                }
                return response.json();
            })
            .then((data) => {
                const list = Array.isArray(data) ? data : (data?.faqs ?? []);
                setFaqs(list);
                setError(null);
                setLoading(false);
            })
            .catch((err) => {
                setError(err.message || "Impossible de charger la FAQ");
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
                        Chargement de la FAQ...
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

    // Etat normal (FAQ disponible)
    return (
        <section
            className="py-16 px-6"
            aria-labelledby="faq-heading"
            style={{
                background:
                    "linear-gradient(180deg, rgba(39,42,199,1) 0%, rgba(143,30,152,1) 35%, rgba(255,15,99,1) 100%)",
            }}
        >
            <div className="container mx-auto">
                <h2
                    id={headingId}
                    className="text-4xl font-bold uppercase mb-12 text-left drop-shadow-lg text-white"
                >
                    Foire aux questions
                </h2>
                <p id="faq-desc" className="sr-only">
                    Réponses aux questions fréquemment posées.
                </p>

                <div className="max-w-2xl mx-auto mt-6 space-y-4">
                    {faqs.length > 0 ? (
                        <ul role="list" aria-label="Liste des questions fréquentes">
                            {faqs.map((faq, idx) => {
                                const itemId =
                                    typeof faq.id !== "undefined" ? faq.id : `faq-${idx}`;
                                const buttonId = `${itemId}-button`;
                                const panelId = `${itemId}-panel`;

                                return (
                                    <li key={itemId} role="listitem" className="mb-3">
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
