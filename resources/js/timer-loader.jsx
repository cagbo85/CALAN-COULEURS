import React from 'react';
import { createRoot } from 'react-dom/client';
import Timer from './components/Timer.jsx';

const rootElement = document.getElementById('timer-root');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<Timer />);
}
