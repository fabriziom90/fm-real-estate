import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.ts',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Roboto Condensed"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "main-blue": "#011A90",
                "warning": "#ffd900",
                "danger": "#da0000",
                'white': "#fff"
            },
            borders: {
                "border-button": "6px solid"
            }
        },
    },

    plugins: [forms],
    // daisyui: {themes:['light'], themeRoot: ':root'}
};

