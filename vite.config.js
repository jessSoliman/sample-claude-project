import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

// Set by the `vite` service in compose.yaml.
const inDocker = process.env.VITE_DOCKER === 'true';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        // Listen on all interfaces inside the container, but hand the browser
        // localhost (via public/hot) so it reaches the published port.
        ...(inDocker && {
            host: '0.0.0.0',
            port: 5173,
            strictPort: true,
            hmr: { host: 'localhost' },
        }),
        watch: {
            // Host file events don't cross a Docker Desktop bind mount, so poll.
            usePolling: inDocker,
            ignored: ['**/storage/framework/views/**', '**/vendor/**'],
        },
    },
});
