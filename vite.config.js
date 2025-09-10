import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.jsx",
                "resources/js/navbar-loader.jsx",
                "resources/js/timer-loader.jsx",
                "resources/js/stands-loader.jsx",
                "resources/js/faq-loader.jsx",
                "resources/js/app.js",
            ],
            publicDirectory: "public",
            refresh: true,
        }),
        tailwindcss(),
        react(),
    ],
});
