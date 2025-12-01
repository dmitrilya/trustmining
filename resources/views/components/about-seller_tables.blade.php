<div class="mt-2 sm:flex flex-wrap gap-1 lg:gap-2">
    @if ($user->passport && !$user->passport->moderation)
        <div
            class="cursor-default inline-flex items-center px-2 py-1 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-md text-xxs text-gray-800 dark:text-gray-200 uppercase shadow-sm dark:shadow-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-800 transition ease-in-out duration-150">
            {{ __('Identity confirmed') }}
        </div>
    @endif

    @if ($user->company && !$user->company->moderation)
        <div
            class="cursor-default inline-flex items-center px-2 py-1 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-md text-xxs text-gray-800 dark:text-gray-200 uppercase shadow-sm dark:shadow-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-800 transition ease-in-out duration-150">
            {{ __('Company verified') }}
        </div>
    @endif

    @if ($user->tariff_id == 3)
        <div
            class="cursor-default inline-flex items-center px-2 py-1 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-md text-xxs text-gray-800 dark:text-gray-200 uppercase shadow-sm dark:shadow-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-800 transition ease-in-out duration-150">
            {{ __('Market leader') }}
        </div>
    @endif
</div>
