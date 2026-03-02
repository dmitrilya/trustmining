const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
    ],

    safelist: ['z-100', 'min-h-[129px]', 'before:content-[""]', 'before:absolute', 'before:left-0', 'before:top-2', 'before:h-0.5', 'before:w-0.5', 'before:bg-current', 'before:rounded-full', 'min-h-56', 'min-h-128', 'max-h-96', 'max-h-128', 'group-hover:bg-slate-200', 'w-32', 'max-h-10', 'rounded-2xl', 'text-green-500', 'bg-green-100', 'rounded-full', 'dark:bg-green-800', 'dark:text-green-200', 'text-red-500', 'bg-red-100', 'rounded-full', 'dark:bg-red-800', 'dark:text-red-200', 'text-orange-500', 'bg-orange-100', 'rounded-full', 'dark:bg-orange-800', 'dark:text-orange-200'],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            gridTemplateRows: {
                '[auto,auto,1fr]': 'auto auto 1fr',
            },
            aspectRatio: {
                '4/3': '4 / 3',
                '16/9': '16 / 9'
            },
            spacing: {
                '112': '28rem',
                '128': '32rem',
                '144': '36rem',
                '160': '40rem',
            },
            screens: {
                'xs': '380px',
                'xxxl': '1664px',
            },
            gridTemplateColumns: {
                '16': 'repeat(16, minmax(0, 1fr))',
                '22': 'repeat(22, minmax(0, 1fr))',
            },
            maxWidth: {
                '8xl': '88rem',
                '9xl': '96rem',
                '10xl': '104rem',
            },
            keyframes: {
                'highlight': {
                    '0%, 50%, 100%': { opacity: '1' },
                    '25%, 75%': { opacity: '0.3' },
                }
            },
            animation: {
                'scrolling-highlight': 'highlight 2s ease-in-out forwards',
            },
            colors: {
                'logo-color': 'rgba(var(--logo-color), var(--logo-opacity))',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        require('flowbite/plugin')
    ],
};
