import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 'resources/js/app.js',
                
                'resources/css/pie-chart.css',
                'resources/js/chart/pie-chart.js',
                'resources/css/bar-chart.css',
                'resources/js/chart/bar-chart.js'
            ],
            refresh: true,
        }),
    ],
});
