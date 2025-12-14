const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
    ],

    safelist: ['min-h-56', 'min-h-128', 'max-h-96', 'max-h-128', 'group-hover:bg-gray-200', 'w-32', 'max-h-10', 'rounded-2xl', 'text-green-500', 'bg-green-100', 'rounded-full', 'dark:bg-green-800', 'dark:text-green-200', 'text-red-500', 'bg-red-100', 'rounded-full', 'dark:bg-red-800', 'dark:text-red-200', 'text-orange-500', 'bg-orange-100', 'rounded-full', 'dark:bg-orange-800', 'dark:text-orange-200'],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
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
                'xs': '380px'
            },
            gridTemplateColumns: {
                '16': 'repeat(16, minmax(0, 1fr))',
                '22': 'repeat(22, minmax(0, 1fr))',
            },
            maxWidth: {
                '8xl': '88rem',
                '9xl': '96rem',
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        require('flowbite/plugin')
    ],
};
