import React from "react";
import FAQItem from "./FAQItem";

export default function FAQSection() {
    const faqs = [
        {
            question: "Où et quand se déroule le festival ?",
            answer: "Rendez-vous à Campbon (44) les 12 & 13 septembre pour deux jours de vibes 🔥",
        },
        {
            question: "À quelle heure ouvrent les portes ?",
            answer: "On t’accueille dès 19h vendredi et 13h samedi. Viens tôt, repars tard 😉",
        },
        {
            question: "Quels sont les styles de musique proposés ?",
            answer: "Électro, rock, rap, dub… On mélange les styles pour faire kiffer tout le monde 🎶",
        },
        {
            question: "Y a-t-il une billetterie sur place ?",
            answer: "Oui, mais sans garantie 😬. Le mieux, c’est de choper ta place en ligne avant que ça parte !",
        },
        {
            question: "Y aura-t-il des espaces de restauration ?",
            answer: "Évidemment ! Foodtrucks, buvette, de quoi manger, boire et recharger les batteries 🍔🍻",
        },
        {
            question: "Pourra-t-on dormir sur place ?",
            answer: "Oui carrément ! Le camping est prévu, ramène juste ton matériel et ta bonne humeur 🌙🎪🔥",
        },
    ];

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
                    {faqs.map((faq, index) => (
                        <FAQItem
                            key={index}
                            question={faq.question}
                            answer={faq.answer}
                        />
                    ))}
                </div>
            </div>
        </section>
    );
}
