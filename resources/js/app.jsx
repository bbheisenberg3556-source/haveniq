import './bootstrap';
import '../css/app.css';

import React from 'react';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

const el = document.getElementById('app');
const scriptElement = document.querySelector('script[data-page="app"][type="application/json"]');
let initialPage;
try {
    if (scriptElement?.textContent) {
        initialPage = JSON.parse(scriptElement.textContent);
    } else if (el?.dataset?.page) {
        initialPage = JSON.parse(el.dataset.page);
    }
} catch (e) {
    console.error('Failed to parse initial Inertia page:', e);
}

createInertiaApp({
    page: initialPage,
    title: (title) => `${title} - HavenIQ`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});
