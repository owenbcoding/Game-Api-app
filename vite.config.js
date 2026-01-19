import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            // In Docker/WSL, watching "everything" can cause huge memory usage and crash Vite.
            // Only watch what actually needs full page refresh.
            refresh: [
                'app/**',
                'resources/views/**',
                'routes/**',
            ],
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        // Bind to 0.0.0.0 for Docker, but make the browser use localhost (0.0.0.0 is not a valid browser host).
        origin: 'http://localhost:5173',
        hmr: {
            host: 'localhost',
            clientPort: 5173,
        },
        watch: {
            // pnpm may create a project-local store in Docker which contains symlink loops.
            // Don't follow symlinks and ignore pnpm store folders to avoid ELOOP crashes.
            followSymlinks: false,
            // Avoid watching massive directories that are unrelated to the frontend dev server.
            ignored: [
                '**/vendor/**',
                '**/storage/**',
                '**/node_modules/**',
                '**/.pnpm-store/**',
                '**/.pnpm/**',
                '**/.git/**',
            ],
        },
    },
});
