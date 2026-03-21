import React from "react";
import { createRoot } from "react-dom/client";
import Navbar from "./components/navbar.jsx";

const navbarRoot = document.getElementById("navbar-root");
if (navbarRoot) {
    const routes = {
        home: navbarRoot.getAttribute("data-home-url") || "/",
        programmation: navbarRoot.getAttribute("data-programmation-url") || null,
        billetterie: navbarRoot.getAttribute("data-billetterie-url") || "{{ $currentEdition->reservation_url }}",
        festival: navbarRoot.getAttribute("data-festival-url") || "/notre-histoire",
        contact: navbarRoot.getAttribute("data-contact-url") || "/contact",
        camping: navbarRoot.getAttribute("data-camping-url") || "/camping",
        benevoles: navbarRoot.getAttribute("data-benevoles-url") || "/benevoles",
        news: navbarRoot.getAttribute("data-news-url") || null,
        charte: navbarRoot.getAttribute("data-charte-url") || "/charte",
        partenaires: navbarRoot.getAttribute("data-partenaires-url") || null,
        photoSouvenirs: navbarRoot.getAttribute("data-photo-souvenirs-url") || null,
    };
    const currentPath = navbarRoot.getAttribute("data-current-path") || window.location.pathname;

    const root = createRoot(navbarRoot);
    root.render(<Navbar routes={routes} currentPath={currentPath} />);
}
