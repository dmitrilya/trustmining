const defaultTheme = require('tailwindcss/defaultTheme');

export default {
    darkMode: 'selector',
    
    content: [
        './resources/views/metrics/network/difficulty/widjet.blade.php',
        './resources/views/metrics/network/difficulty/components/difficulty.blade.php',
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