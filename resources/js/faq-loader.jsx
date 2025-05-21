import React from 'react';
import { createRoot } from 'react-dom/client';
import FAQSection from './components/FAQSection';

const rootElement = document.getElementById('faq-root');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<FAQSection />);
}
