import React from "react";
import { createRoot } from "react-dom/client";
import NavbarBoutique from "./components/navbar-boutique.jsx";

const navbarRoot = document.getElementById("navbarBoutique-root");
if (navbarRoot) {
    const routes = {
        home: navbarRoot.getAttribute("data-home-url") || "/",
        pulls: navbarRoot.getAttribute("data-pulls-url") || null,
        tshirts: navbarRoot.getAttribute("data-tshirts-url") || null,
        accessoires: navbarRoot.getAttribute("data-accessoires-url") || null,
        contact: navbarRoot.getAttribute("data-contact-url") || null,
        cart: navbarRoot.getAttribute("data-cart-url") || null,
    };
    const initialCartCount = Number(
        navbarRoot.getAttribute("data-cart-count") || 0,
    );

    const root = createRoot(navbarRoot);

    root.render(
        <NavbarBoutique routes={routes} initialCartCount={initialCartCount} />,
    );
}
