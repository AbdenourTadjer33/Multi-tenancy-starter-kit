import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";
import react from '@vitejs/plugin-react';
import tailwindcss from 'tailwindcss';
import path from "path";

export default defineConfig(({ mode }) => {
    Object.assign(process.env, loadEnv(mode, '.'));

    return {
        server: {
            host: process.env.VITE_APP_ADMIN_DOMAIN,
        },
        plugins: [
            laravel({
                // hotFile: 'public/tenant-admin.hot',
                buildDirectory: 'themes/tenant-admin',
                input: ['resources/js/tenant-admin/app.tsx', 'resources/css/tenant-admin.css'],
                refresh: true,
            }),
            react()
        ],
        resolve: {
            alias: {
                '@/tenant-admin': path.resolve(__dirname, './resources/js/tenant-admin')
            }
        },
        css: {
            postcss: {
                plugins: [
                    tailwindcss({
                        config: './tailwind-tenant-admin.config.js',
                    }),
                ],
            },
        },
    }
});