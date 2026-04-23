import './bootstrap';
import '../css/app.css';

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ThemeSwitcherProvider } from './Context/ThemeSwitcherContext';
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(
            <ThemeSwitcherProvider>
                <App {...props} />
            </ThemeSwitcherProvider>
        );

        if (window.__bootFallbackTimer) {
            clearTimeout(window.__bootFallbackTimer);
        }

        document.body.classList.remove('boot-fallback-visible');
        const fallback = document.getElementById('boot-fallback');
        if (fallback) {
            fallback.remove();
        }

        document.body.classList.add('app-ready');
    },
    progress: {
        color: '#4B5563',
    },
});
