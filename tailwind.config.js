import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/usernotnull/tall-toasts/config/**/*.php',
        './vendor/usernotnull/tall-toasts/resources/views/**/*.blade.php',
        // './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            colors: {
                // Light mode colors
                light: {
                    background: 'rgb(248 250 252)',
                    text: '#000000',
                },
                // Dark mode colors
                dark: {
                    background: 'rgb(17 24 39)',
                    component: 'rgb(31 41 55)',
                    text: 'rgb(209 213 219)',
                    button: ''
                },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants: {
        extend: {
            backgroundColor: ['dark'], // Enables dark mode for background color
            textColor: ['dark'],        // Enables dark mode for text color
        },
    },

    plugins: [forms, require('daisyui'), require('flowbite/plugin')],
};


