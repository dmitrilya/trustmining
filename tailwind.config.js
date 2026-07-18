const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './resources/views/**/*.blade.php',
        '!./resources/views/roadmap.blade.php',
    ],

    safelist: [
        'min-h-[129px]', 'before:content-[""]', 'before:absolute', 'before:left-0', 'before:top-2', 'before:h-0.5', 'before:w-0.5', 'before:bg-current', 'before:rounded-full',
        'bg-green-100', 'dark:bg-green-800', 'dark:text-green-200',
        'from-red-800/40', 'to-red-900/20', 'dark:to-slate-900', 'border-red-500/60', 'shadow-[inset_0_0_12px_rgba(239,68,68,0.15)]', 'bg-red-500', 'shadow-[0_0_20px_rgba(239,68,68,0.25)]', 'from-amber-800/40', 'to-amber-900/10', 'border-amber-500/50', 'shadow-[inset_0_0_12px_rgba(217,70,239,0.15)]', 'bg-amber-500', 'shadow-[0_0_15px_rgba(217,70,239,0.2)]', 'from-indigo-800/40', 'to-indigo-900/10', 'border-indigo-500/50', 'shadow-[inset_0_0_12px_rgba(99,102,241,0.1)]', 'shadow-[0_0_10px_rgba(99,102,241,0.15)]'
    ],
    darkMode: 'class',
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
                'xxs': '360px',
                'xs': '380px',
                'xxl': '1420px',
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
        //require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
    ],
};
