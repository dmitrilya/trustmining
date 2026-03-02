@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center border-b-2 border-indigo-400 dark:border-indigo-700 text-sm leading-5 text-slate-950 dark:text-slate-50 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center border-b-2 border-transparent text-sm leading-5 text-slate-600 dark:text-slate-300 hover:text-slate-700 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600 focus:outline-none focus:text-slate-700 dark:focus:text-slate-300 focus:border-slate-300 dark:focus:border-slate-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
