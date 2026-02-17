import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                sisc: {
                    purple: 'var(--sisc-purple, #2E1065)',
                    gold: 'var(--sisc-gold, #F59E0B)',
                }
            },
            borderRadius: {
                'none': '0',
                'sm': '2px',
                DEFAULT: '2px',
                'md': '2px',
                'lg': '2px',
                'xl': '2px',
                '2xl': '2px',
                '3xl': '2px',
                'full': '9999px',
            }
        },
    },

    plugins: [forms],
};
