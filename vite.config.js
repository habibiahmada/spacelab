import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',

                'resources/js/staff/student-index.js',
                'resources/css/home-animations.css',
                'resources/js/home-interactions.js',
            ],
            refresh: true,
        }),
    ],
});
