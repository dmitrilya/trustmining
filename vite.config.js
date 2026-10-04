import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            publicDirectory: 'public',
            input: [
                'resources/css/app.css',
                'resources/css/calculator.css',
                'resources/css/difficulty.css',
                'resources/js/app.js',
                'resources/js/graph.js',
                'resources/js/calculator.js',
                'resources/js/difficulty.js',
                'resources/js/calculator-widjet.js',
                'resources/js/difficulty-widjet.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        rollupOptions: {
            output: {
                entryFileNames: (chunkInfo) => {
                    return chunkInfo.name === 'calculator-widjet' || chunkInfo.name === 'difficulty-widjet'
                        ? 'assets/[name].js'
                        : 'assets/[name]-[hash].js';
                },
            }
        }
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
