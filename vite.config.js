import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            publicDirectory: 'public',
            input: [
                'resources/css/app.css',
                'resources/css/calculator.css',
                'resources/js/app.js',
                'resources/js/graph.js',
                'resources/js/graph.js',
                'resources/js/calculator.js',
            ],
            refresh: true,
        }),
    ],
});
