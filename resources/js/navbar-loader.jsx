import React from "react";
import { createRoot } from "react-dom/client";
import Navbar from "./components/navbar.jsx";

const navbarRoot = document.getElementById("navbar-root");
if (navbarRoot) {
    const routes = {
        home: navbarRoot.getAttribute("data-home-url") || "/",
        programmation: navbarRoot.getAttribute("data-programmation-url") || "/programmation",
        billetterie: navbarRoot.getAttribute("data-billetterie-url") || "https://www.helloasso.com/associations/calan-couleurs/evenements/festival-calan-couleurs",
        festival: navbarRoot.getAttribute("data-festival-url") || "/notre-histoire",
        contact: navbarRoot.getAttribute("data-contact-url") || "/contact",
        // Nouvelles routes
        camping: navbarRoot.getAttribute("data-camping-url") || "/camping",
        benevoles: navbarRoot.getAttribute("data-benevoles-url") || "/benevoles",
        news: navbarRoot.getAttribute("data-news-url") || "/news",
        charte: navbarRoot.getAttribute("data-charte-url") || "/charte",
        partenaires: navbarRoot.getAttribute("data-partenaires-url") || "/partenaires",
    };
    const currentPath = navbarRoot.getAttribute("data-current-path") || window.location.pathname;

    const root = createRoot(navbarRoot);
    root.render(<Navbar routes={routes} currentPath={currentPath} />);
}
