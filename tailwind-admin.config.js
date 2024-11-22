import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: ['media'],
    content: [
        './resources/views/admin.blade.php',
        './resources/js/admin/**/*.tsx',
    ],
    theme: {},
    plugins: []
}