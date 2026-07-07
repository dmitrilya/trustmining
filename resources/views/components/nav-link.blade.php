@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center border-b-2 border-indigo-400 dark:border-indigo-700 text-sm leading-5 text-slate-800 dark:text-slate-200 focus:outline-none focus:border-indigo-700 transition duration-100 ease-in-out'
            : 'inline-flex items-center border-b-2 border-transparent text-sm leading-5 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-300 dark:hover:border-slate-600 focus:outline-none focus:text-slate-800 dark:focus:text-slate-200 focus:border-slate-300 dark:focus:border-slate-600 transition duration-100 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
