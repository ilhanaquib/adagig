import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Caveat', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#FFA90A',
                secondary: '#6D0000',
                accent: '#263337',
                dark: '#1F2937',
                light: '#FFFDFA',
            },
        },
    },

    plugins: [forms, typography],
};
