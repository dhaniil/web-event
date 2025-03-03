import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Frontend assets
                'resources/css/app.css',
                'resources/css/dashboard.css',
                'resources/css/empty-state.css',
                'resources/css/show.css',
                'resources/css/eventonly.css',
                'resources/css/profile.css',
                'resources/css/sidebar.css',
                'resources/css/create.css',
                'resources/css/assets/asset.css',
                'resources/js/app.js',
                'resources/js/filament/dashboard/move.js',
                
                // Filament theme
                'resources/css/filament/admin/theme.css'
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['vue']
                }
            }
        }
    }
});
