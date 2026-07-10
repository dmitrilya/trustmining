@props([
    'targetWidth' => 1024,
    'class' =>
        'bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl',
])

<div class="{{ $class }}" data-aikodex-inline data-inline-min="{{ $targetWidth }}" data-inline-bare></div>
