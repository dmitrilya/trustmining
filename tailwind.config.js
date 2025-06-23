const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
    ],

    safelist: ['min-h-56', 'min-h-128', 'max-h-96', 'max-h-128', 'group-hover:bg-gray-200', 'w-32', 'max-h-10', 'rounded-2xl'],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Huninn', ...defaultTheme.fontFamily.sans],
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
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        require('flowbite/plugin')
    ],
};
