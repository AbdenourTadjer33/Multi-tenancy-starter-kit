import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    Object.assign(process.env, loadEnv(mode, '.'));
    
    return {
        server: {
            host: process.env.VITE_APP_DOMAIN,
        },
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
        ],
    }
});
