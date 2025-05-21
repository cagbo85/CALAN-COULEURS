import React from 'react';
import OnSiteFeature from './OnSiteFeature';

export default function OnSiteSection() {
  // Stands
  const stands = [
    {
      title: '🛟 Stand Prévention & Sécurité',
      description: "Sensibiliser tout en s'amusant ! Infos, jeux et conseils pour faire la fête en toute sécurité, avec le sourire et les bons réflexes.",
      imageSrc: '/img/surplace/prevention.jpg'
    },
    {
        title: '👚🛍️ Friperie & Boutique Calan\'Couleurs',
        description: "Double plaisir sur ce stand : chinez des vêtements vintage uniques à prix doux pour danser avec style, et repartez avec des souvenirs du festival (t-shirts, tote bags, stickers...) à l'effigie de Calan'Couleurs !",
        imageSrc: '/img/surplace/friperie.png'
    },
    {
      title: '🖋 Stand Tatouage',
      description: "Envie d'un souvenir indélébile ? Découvre nos tatoueurs présents pour te laisser une trace de Calan'.",
      imageSrc: '/img/surplace/tatouage.webp'
    },
  ];

  // Food trucks
  const foodTrucks = [
    {
      title: 'Sylvain Tacos et Burgers',
      description: "Tacos garnis de viandes juteuses, burgers généreux, paninis grillés, une sélection de snacks et de petites bouchées pour les petites faims.",
      imageSrc: '/img/surplace/food2sylvain.webp',
      website: "https://www.sylvain-tacos-burgers.fr/"
    },
    {
      title: 'So\'Galettes',
      description: "Je vous propose des galettes et crêpes garnies traditionnelles ou originales, pour un goût authentique de la Bretagne.",
      imageSrc: '/img/surplace/sogalettes.jpg',
      website: "https://www.facebook.com/profile.php?id=100057631532634"
    }
  ];

  return (
    <section className="py-12 px-6 bg-white">
      <div className="container mx-auto">
        <h2 className="text-[#8F1E98] text-3xl font-bold uppercase mb-10 text-center md:text-left">Sur place</h2>

        {/* Stands */}
        <div className="mb-16">
          <h3 className="text-[#FF0F63] text-2xl font-semibold mb-8 ml-4 text-center md:text-left">Nos stands</h3>
          <div className="flex flex-wrap justify-center gap-8">
            {stands.map((item, index) => (
              <div key={index} className="w-full sm:w-80">
                <OnSiteFeature title={item.title} description={item.description} imageSrc={item.imageSrc} />
              </div>
            ))}
          </div>
        </div>

        {/* Food Trucks */}
        <div>
          <h3 className="text-[#FF0F63] text-2xl font-semibold mb-8 ml-4 text-center md:text-left">Food Trucks</h3>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-8 justify-items-center">
            {foodTrucks.map((item, index) => (
              <OnSiteFeature key={index} title={item.title} description={item.description} imageSrc={item.imageSrc} website={item.website} />
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
