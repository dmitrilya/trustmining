const defaultTheme = require('tailwindcss/defaultTheme');

export default {
    darkMode: 'selector',

    content: [
        './resources/views/calculator/widjet.blade.php',
        './resources/views/calculator/components/calculator.blade.php',
        './resources/views/calculator/components/selectversion.blade.php',
        './resources/views/calculator/components/settings.blade.php',
        './resources/views/calculator/components/characteristics.blade.php',
        './resources/views/calculator/components/currency.blade.php',
        './resources/views/calculator/components/profit.blade.php',
        './resources/views/calculator/components/coins.blade.php',
        './resources/views/components/application-logo.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            screens: {
                'xs': '380px',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
}