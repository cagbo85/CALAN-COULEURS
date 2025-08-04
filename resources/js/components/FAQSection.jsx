import React, { useState, useEffect } from "react";
import FAQItem from "./FAQItem";

export default function FAQSection() {
    const [faqs, setFaqs] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchFaqs();
    }, []);

    const fetchFaqs = async () => {
        try {
            const response = await fetch('/api/faqs');
            const data = await response.json();
            setFaqs(data);
        } catch (error) {
            console.error('Erreur lors du chargement des FAQs:', error);
            // FAQs de fallback en cas d'erreur
            setFaqs([
                {
                    question: "Où et quand se déroule le festival ?",
                    answer: "Rendez-vous à Campbon (44) les 12 & 13 septembre pour deux jours de vibes 🔥",
                },
                {
                    question: "À quelle heure ouvrent les portes ?",
                    answer: "On t'accueille dès 19h vendredi et 13h samedi. Viens tôt, repars tard 😉",
                }
            ]);
        } finally {
            setLoading(false);
        }
    };

    if (loading) {
        return (
            <section className="py-16 px-6" style={{
                background: "linear-gradient(180deg, rgba(39,42,199,1) 0%, rgba(143,30,152,1) 35%, rgba(255,15,99,1) 100%)",
            }}>
                <div className="container mx-auto">
                    <h2 className="text-white text-3xl font-bold uppercase mb-10">
                        Foire aux questions
                    </h2>
                    <div className="max-w-2xl mx-auto">
                        <div className="text-white text-center">Chargement des FAQs...</div>
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
        >
            <div className="container mx-auto">
                <h2 className="text-white text-3xl font-bold uppercase mb-10">
                    Foire aux questions
                </h2>
                <div className="max-w-2xl mx-auto space-y-4">
                    {faqs.map((faq) => (
                        <FAQItem
                            key={faq.id}
                            question={faq.question}
                            answer={faq.answer}
                        />
                    ))}
                </div>
            </div>
        </section>
    );
}
