import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js', 'resources/js/bootstrap5-toggle.ecmas.min.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            $: 'jquery',
            jQuery: 'jquery',
        },
    },
});
