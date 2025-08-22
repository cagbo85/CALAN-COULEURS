import React from "react";
import OnSiteFeature from "./OnSiteFeature";

export default function OnSiteSection() {
    // Stands
    const stands = [
        {
            title: "🛟 Stand Prévention & Sécurité",
            description:
                "Sensibiliser tout en s'amusant ! Infos, jeux et conseils pour faire la fête en toute sécurité, avec le sourire et les bons réflexes.",
            imageSrc: "/img/surplace/prevention.jpg",
        },
        {
            title: "👚🛍️ Friperie & Boutique Calan'Couleurs",
            description:
                "Double plaisir sur ce stand : chinez des vêtements vintage uniques à prix doux pour danser avec style, et repartez avec des souvenirs du festival (t-shirts, tote bags, stickers...) à l'effigie de Calan'Couleurs !",
            imageSrc: "/img/surplace/friperie.png",
        },
        {
            title: "🖋 Stand Tatouage",
            description:
                "Envie d'un souvenir indélébile ? Découvre nos tatoueurs présents pour te laisser une trace de Calan'.",
            imageSrc: "/img/surplace/tatouage.webp",
        },
    ];

    // Food trucks
    const foodTrucks = [
        {
            title: "Sylvain Tacos et Burgers",
            description:
                "Tacos garnis de viandes juteuses, burgers généreux, paninis grillés, une sélection de snacks et de petites bouchées pour les petites faims.",
            imageSrc: "/img/surplace/food2sylvain.webp",
            website: "https://www.sylvain-tacos-burgers.fr/",
        },
        {
            title: "So'Galettes",
            description:
                "Je vous propose des galettes et crêpes garnies traditionnelles ou originales, pour un goût authentique de la Bretagne.",
            imageSrc: "/img/surplace/sogalettes.jpg",
            website: "https://www.facebook.com/profile.php?id=100057631532634",
        },
    ];

    return (
        <section
            className="py-12 px-6 bg-white"
            aria-labelledby="onsite-heading"
            aria-describedby="onsite-desc"
        >
            <div className="container mx-auto">
                <h2
                    id="onsite-heading"
                    className="text-[#8F1E98] text-3xl font-bold uppercase mb-2 text-center md:text-left"
                >
                    Sur place
                </h2>
                <p id="onsite-desc" className="sr-only">
                    Informations sur les stands du festival et les food trucks
                    disponibles sur le site.
                </p>

                {/* Stands */}
                <div className="mb-16">
                    <h3 className="text-[#FF0F63] text-2xl font-semibold mb-6 ml-4 text-center md:text-left">
                        Nos stands
                    </h3>

                    {/* Liste sémantique */}
                    <ul
                        role="list"
                        className="flex flex-wrap justify-center gap-8"
                        aria-label="Liste des stands présents sur le site"
                    >
                        {stands.map((item, index) => {
                            const accessibleTitle = toAccessibleTitle(
                                item.title
                            );
                            return (
                                <li
                                    key={index}
                                    role="listitem"
                                    className="w-full sm:w-80"
                                >
                                    <OnSiteFeature
                                        title={item.title}
                                        description={item.description}
                                        imageSrc={item.imageSrc}
                                        imageAlt={`${accessibleTitle} — illustration du stand`}
                                    />
                                </li>
                            );
                        })}
                    </ul>
                </div>

                {/* Food Trucks */}
                <div>
                    <h3 className="text-[#FF0F63] text-2xl font-semibold mb-6 ml-4 text-center md:text-left">
                        Food Trucks
                    </h3>

                    {/* Liste sémantique */}
                    <ul
                        role="list"
                        className="grid grid-cols-1 md:grid-cols-2 gap-8 justify-items-center"
                        aria-label="Liste des food trucks disponibles sur le site"
                    >
                        {foodTrucks.map((item, index) => {
                            const accessibleTitle = toAccessibleTitle(
                                item.title
                            );
                            return (
                                <li
                                    key={index}
                                    role="listitem"
                                    className="w-full md:w-[36rem]"
                                >
                                    <OnSiteFeature
                                        title={item.title}
                                        description={item.description}
                                        imageSrc={item.imageSrc}
                                        imageAlt={`${accessibleTitle} — illustration du food truck`}
                                        website={item.website}
                                        // Indique aux lecteurs d’écran “nouvelle fenêtre”
                                        websiteLabel={`${accessibleTitle} — site officiel (nouvelle fenêtre)`}
                                    />
                                </li>
                            );
                        })}
                    </ul>
                </div>
            </div>
        </section>
    );
}
