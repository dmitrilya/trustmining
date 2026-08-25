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
        './resources/views/calculator/components/tax-help.blade.php',
        './resources/views/components/application-logo.blade.php',
        './resources/views/components/inputs/checkbox.blade.php',
        './resources/views/components/inputs/select.blade.php',
        './resources/views/components/inputs/radio.blade.php',
        './resources/views/components/inputs/text-input.blade.php',
    ],

    safelist: [
        'mt-1.5', 'mb-1', 'xxs:text-xs', 'font-mono', 'tracking-tight', 'text-blue-700', 'dark:text-blue-300', 'text-yellow-300', 'bg-emerald-500/10', 'text-emerald-600', 'dark:text-emerald-400', 'bg-amber-500/10', 'text-amber-600', 'dark:text-amber-400', 'bg-rose-500/10', 'text-rose-600', 'dark:text-rose-400'
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