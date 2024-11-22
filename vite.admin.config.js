import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import tailwindcss from "tailwindcss";
import path from "path";

export default defineConfig(({ mode }) => {
    Object.assign(process.env, loadEnv(mode, '.'));

    return {
        server: {
            host: process.env.VITE_APP_ADMIN_DOMAIN,
        },
        plugins: [
            laravel({
                // hotFile: 'public/admin.hot',
                buildDirectory: 'themes/admin',
                input: ['resources/js/admin/app.tsx', 'resources/css/admin.css'],
                refresh: true
            }),
            react()
        ],
        resolve: {
            alias: {
                '@/admin': path.resolve(__dirname, './resources/js/admin')
            }
        },
        css: {
            postcss: {
                plugins: [
                    tailwindcss({
                        config: './tailwind-admin.config.js'
                    })
                ]
            }
        }
    }
})