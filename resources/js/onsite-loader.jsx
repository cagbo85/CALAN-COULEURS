import React from 'react';
import { createRoot } from 'react-dom/client';
import OnSiteSection from './components/OnSiteSection';

const rootElement = document.getElementById('onsite-root');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<OnSiteSection />);
}
