@props(['title', 'class' => 'p-2 sm:p-3'])

<div class="{{ $class }} bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl">
    <h2 class="text-xs text-slate-500 uppercase tracking-widest mb-2">
        {{ __($title) }}
    </h2>

    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mb-4">
        {{ __('Take control: update your data in one click and control everything your profile visitors see.') }}
    </p>

    <a href="https://t.me/trustmining_ru" target="_blank" class="block w-full">
        <x-buttons.primary-button class="w-full">{{ __('Contact in telegram') }}</x-buttons.primary-button>
    </a>
</div>
