@props(['tf'])

<div
    {{ $attributes->merge(['class' => 'flex items-center w-fit px-1.5 py-0.5 rounded-full border ' . ($tf > config('trustfactor.yellow') ? ($tf > config('trustfactor.green') ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-800 dark:text-emerald-400' : 'bg-amber-500/10 border-amber-500/30 text-amber-600 dark:text-amber-400') : 'bg-rose-500/10 border-rose-500/30 text-rose-600 dark:text-rose-400')]) }}>
    <svg class="trust mr-1 sm:mr-2 w-2 h-2 xs:w-3 xs:h-3" width="100" height="100" viewBox="0 0 100 100" xmlns="http://w3.org">
        <circle cx="50" cy="50" r="40" fill="currentColor" />
    </svg>
    <p class="text-xxs sm:text-xs uppercase">{{ __('Trust Factor') }}</p>
</div>
