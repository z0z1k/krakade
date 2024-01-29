import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/main.css',
                'resources/css/loader.css',
                'resources/js/bootstrap.js',
                'resources/js/map.js',
                'resources/js/orders_create.js',
                'resources/js/websocket.js',

            ],
            refresh: true,
        }),
    ],
});
