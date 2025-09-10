import React from 'react';
import { createRoot } from 'react-dom/client';
import StandsSection from './components/StandsSection';

const rootElement = document.getElementById('stands-root');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<StandsSection />);
}
