import React from 'react';
import { createRoot } from 'react-dom/client';
import PartnersSection from './components/PartnersSection';

const rootElement = document.getElementById('partners-root');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<PartnersSection />);
}
