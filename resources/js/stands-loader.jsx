import React from "react";
import ReactDOM from "react-dom/client";
import StandsSection from './components/StandsSection';

ReactDOM.createRoot(
    document.getElementById("stands-root"),
).render(
    <React.StrictMode>
        <StandsSection />
    </React.StrictMode>,
);
