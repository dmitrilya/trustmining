<div class="mt-2 sm:flex flex-wrap gap-1 lg:gap-2">
    @if ($user->first)
        <div
            class="cursor-default inline-flex items-center px-2 py-1 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 border border-slate-300 dark:border-slate-700 rounded-md text-xxs text-slate-800 dark:text-slate-200 uppercase shadow-sm shadow-logo-color hover:bg-slate-50 dark:hover:bg-slate-800 transition ease-in-out duration-150">
            {{ __('Priority partner') }}
        </div>
    @endif

    @if ($user->passport && !$user->passport->moderation)
        <div
            class="cursor-default inline-flex items-center px-2 py-1 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 border border-slate-300 dark:border-slate-700 rounded-md text-xxs text-slate-800 dark:text-slate-200 uppercase shadow-sm shadow-logo-color hover:bg-slate-50 dark:hover:bg-slate-800 transition ease-in-out duration-150">
            {{ __('Identity confirmed') }}
        </div>
    @endif

    @if ($user->company && !$user->company->moderation)
        <div
            class="cursor-default inline-flex items-center px-2 py-1 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 border border-slate-300 dark:border-slate-700 rounded-md text-xxs text-slate-800 dark:text-slate-200 uppercase shadow-sm shadow-logo-color hover:bg-slate-50 dark:hover:bg-slate-800 transition ease-in-out duration-150">
            {{ __('Company verified') }}
        </div>
    @endif

    @if ($user->company && $user->company->registry)
        <div
            class="cursor-default inline-flex items-center px-2 py-1 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 border border-slate-300 dark:border-slate-700 rounded-md text-xxs text-slate-800 dark:text-slate-200 uppercase shadow-sm shadow-logo-color hover:bg-slate-50 dark:hover:bg-slate-800 transition ease-in-out duration-150">
            {{ __('Mining operator') }}
        </div>
    @endif

    @if ($user->tariff_id == 3)
        <div
            class="cursor-default inline-flex items-center px-2 py-1 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 border border-slate-300 dark:border-slate-700 rounded-md text-xxs text-slate-800 dark:text-slate-200 uppercase shadow-sm shadow-logo-color hover:bg-slate-50 dark:hover:bg-slate-800 transition ease-in-out duration-150">
            {{ __('Market leader') }}
        </div>
    @endif
</div>
