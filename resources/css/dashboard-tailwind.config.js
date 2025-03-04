import preset from '../../vendor/filament/support/tailwind.config.preset';
import forms from '@tailwindcss/forms';
const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
export default {
    presets: [
        preset,
    ],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
        // "./vendor/wireui/wireui/src/*.php",
        // "./vendor/wireui/wireui/ts/**/*.ts",
        // "./vendor/wireui/wireui/src/WireUi/**/*.php",
        // "./vendor/wireui/wireui/src/Components/**/*.php",
    ],
    daisyui: {
        themes: [
            {
                mytheme: {
                    "primary": "#00395D",
                    "secondary": "#C96767",
                    "accent": "#37cdbe",
                    "neutral": "#3d4451",
                    "base-100": "#ffffff",
                    'red': '#C96767',
                },
            },
            "dark",
            "cupcake",
        ],
    },
    theme: {
        extend: {
            colors: {
                custom: {
                    900: '#00395D', // Base color
                    800: '#004B77', // 10% lighter
                    700: '#005D91', // 20% lighter
                    600: '#006FAB', // 30% lighter
                    500: '#0081C5', // 40% lighter
                    400: '#0093DF', // 50% lighter
                    300: '#1FA5E9', // 60% lighter
                    200: '#4DB8EF', // 70% lighter
                    100: '#7BCAF5', // 80% lighter
                    50: '#A9DCF9',  // 90% lighter
                },
                primary: {
                    900: '#00395D', // Original/Base color
                    800: '#004B77', // 20% lighter
                    700: '#005D91', // 40% lighter
                    600: '#006FAB', // 60% lighter
                    500: '#0081C5', // 80% lighter
                    400: '#0093DF', // 100% lighter
                    300: '#1FA5E9', // 120% lighter
                    200: '#4DB8EF', // 140% lighter
                    100: '#7BCAF5', // 160% lighter
                    50: '#A9DCF9',  // 180% lighter
                },
                secondary: {
                    900: '#000000', // Original/Base color
                    800: '#000000', // 20% lighter
                    700: '#000000', // 40% lighter
                    600: '#000000', // 60% lighter
                    500: '#000000', // 80% lighter
                    400: '#000000', // 100% lighter
                    300: '#000000', // 120% lighter
                    200: '#000000', // 140% lighter
                    100: '#000000', // 160% lighter
                    50: '#000000',  // 180% lighter
                },
                success: {
                    100: '#E6F9F2',
                    200: '#C8F2E3',
                    300: '#A9EBDA',
                    400: '#8BE4CB',
                    500: '#6CDDCB',
                },
                warning: {
                    100: '#FFF7E6',
                    200: '#FFE1B5',
                    300: '#FFCC85',
                    400: '#FFB754',
                    500: '#FFA223',
                },
                danger: {
                    100: '#FFE6E6',
                    200: '#FFB3B3',
                    300: '#FF8080',
                    400: '#FF4D4D',
                    500: '#FF1A1A',
                },
                info: {
                    100: '#E6F9F2',
                    200: '#C8F2E3',
                    300: '#A9EBDA',
                    400: '#8BE4CB',
                    500: '#6CDDCB',
                },
            },
            fontFamily: {
                Poppins: ["Poppins", "sans-serif"],
            }
        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: colors.black,
            white: colors.white,
            gray: colors.neutral,
            indigo: colors.indigo,
            red: colors.rose,
            yellow: colors.amber,
            primary: colors.amber,
            warning: colors.yellow,
            danger: colors.danger,
        }
    },

    plugins: [
        forms,
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require("daisyui")
    ],
};
