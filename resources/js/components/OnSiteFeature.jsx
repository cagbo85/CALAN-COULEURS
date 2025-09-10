import React from 'react';

export default function OnSiteFeature({ title, description, imageSrc, imageAlt, website, websiteLabel }) {
  return (
    <div className="flex flex-col items-start space-y-3 max-w-xs">
      <div className="w-full h-72 bg-gray-300 border-b-4 border-r-4 border-[#8F1E98] shadow-md overflow-hidden">
        <img
          src={imageSrc}
          alt={imageAlt || title}
          className="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
        />
      </div>
      <h4 className="text-[#8F1E98] text-lg font-bold">{title}</h4>
      <p className="text-gray-700 text-sm">{description}</p>
      {website && (
        <a
          href={website}
          target="_blank"
          rel="noopener noreferrer"
          className="text-[#FF0F63] hover:text-[#8F1E98] font-semibold text-sm transition-colors duration-300"
          aria-label={websiteLabel || `Visiter le site de ${title} (nouvelle fenêtre)`}
        >
          Visiter leur site →
        </a>
      )}
    </div>
  );
}
