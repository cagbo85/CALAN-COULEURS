import React from "react";
import ReactDOM from "react-dom/client";
import { ButtonPrimary, ButtonSecondary, ButtonDanger } from "./components";

// Définir quels composants sont disponibles
const components = {
    buttonPrimary: <ButtonPrimary text="Bouton Principal" onClick={() => alert("Bouton Principal cliqué !")} />,
    buttonSecondary: <ButtonSecondary text="Bouton Secondaire" onClick={() => alert("Bouton Secondaire cliqué !")} />,
    default: <p>Aucun composant sélectionné</p>,
};

// Sélectionner le composant selon `data-component`
const element = document.getElementById("app");
const component = element?.dataset?.component || "default";

ReactDOM.createRoot(element).render(components[component] || components.default);
