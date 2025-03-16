import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                poppins: ["Poppins", "sans-serif"],
            },
            colors: {
                primary: {
                    50: "#F1ECFA",
                    100: "#D8C8F1",
                    200: "#BEA3E8",
                    300: "#A47EDD",
                    400: "#8B5BD4",
                    500: "#7F56C6 ",
                    600: "#704EB3",
                    700: "#60449F",
                    800: "#503B8C",
                    900: "#403278",
                },
                "primary-light": {
                    50: "#FFF8F1",
                    100: "#FFEEDD",
                    200: "#FFDDB5",
                    300: "#FFCB8D",
                    400: "#FFB964",
                    500: "#FCB649",
                    600: "#D89D3F",
                    700: "#B38435",
                    800: "#8F6A2B",
                    900: "#6B5121",
                },
                secondary: {
                    50: "#f9fafb",
                    100: "#f4f5f7",
                    200: "#e5e7eb",
                    300: "#d2d6dc",
                    400: "#9fa6b2",
                    500: "#6b7280",
                    600: "#4b5563",
                    700: "#374151",
                    800: "#252f3f",
                    900: "#161e2e",
                },
                success: {
                    50: "#f0fdf4",
                    100: "#dcfce7",
                    200: "#bbf7d0",
                    300: "#86efac",
                    400: "#4ade80",
                    500: "#22c55e",
                    600: "#16a34a",
                    700: "#15803d",
                    800: "#166534",
                    900: "#14532d",
                },
                danger: {
                    50: "#fdf2f2",
                    100: "#fde8e8",
                    200: "#fbd5d5",
                    300: "#f8b4b4",
                    400: "#f98080",
                    500: "#f05252",
                    600: "#e02424",
                    700: "#c81e1e",
                    800: "#9b1c1c",
                    900: "#771d1d",
                },
                warning:{
                    50: "#fffaf0",
                    100: "#feebc8",
                    200: "#fbd38d",
                    300: "#f6ad55",
                    400: "#ed8936",
                    500: "#dd6b20",
                    600: "#c05621",
                    700: "#9c4221",
                    800: "#7b341e",
                    900: "#652b19",
                }
            },
        },
    },

    plugins: [forms],
};
