import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');

    return {
        plugins: [
            laravel({
                publicDirectory: env.APP_PUBLIC_DIR || 'public',
                input: [
                    'resources/css/app.css',
                    'resources/css/widjets/calculator.css',
                    'resources/css/widjets/difficulty.css',
                    'resources/js/app.js',
                    'resources/js/graph.js',
                    'resources/js/widjets/calculator.js',
                    'resources/js/widjets/difficulty.js',
                    'resources/js/widjets/calculator-widjet.js',
                    'resources/js/widjets/difficulty-widjet.js',
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
            host: '127.0.0.1',
            watch: {
                ignored: ['**/storage/framework/views/**'],
            },
        },
        css: {
            target: ['chrome110', 'firefox110', 'safari16.4', 'edge110']
        }
    }
});
