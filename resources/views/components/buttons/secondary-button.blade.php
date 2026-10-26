@props(['variant' => 'default'])

@php
    $variantClasses = match ($variant) {
        'emerald' => 'bg-emerald-500/10 border border-emerald-500/30 shadow-emerald-500/30 hover:shadow-emerald-500/30 hover:text-emerald-600 dark:hover:text-emerald-400',
        'rose' => 'bg-rose-500/10 border border-rose-500/30 shadow-rose-500/30 hover:shadow-rose-500/30 hover:text-rose-600 dark:hover:text-rose-400',
        default => 'bg-white/40 dark:bg-slate-900/40 border-0 ring-1 ring-inset ring-slate-300 dark:ring-slate-700 shadow-logo-color hover:shadow-logo-color disabled:opacity-25',
    };
@endphp

<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'flex items-center justify-center px-4 py-2 rounded-lg font-extrabold text-xs sm:text-sm text-slate-800 dark:text-slate-200 uppercase tracking-widest shadow hover:shadow-md hover:-translate-y-0.5 focus:outline-none transition ease-in-out duration-100 ' . $variantClasses]) }}>
    {{ $slot }}
</button>
