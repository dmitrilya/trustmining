<div x-show="filter" class="fixed z-40" style="display: none" role="dialog" aria-modal="true">
    <div x-show="filter" class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <div x-show="filter"
        class="fixed top-0 right-0 p-4 h-max w-full sm:max-w-sm flex-col overflow-y-auto bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 backdrop-blur-2xl shadow-md shadow-logo-color flex ml-auto"
        x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" @click.away="filter = false">
        <div class="flex items-center justify-between">
            <h3 class="text-lg text-gray-950 dark:text-gray-100">{{ __('Filters') }}</h3>

            <button type="button"
                class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white dark:bg-zinc-950 p-2 text-gray-500"
                @click="filter = false">
                <span class="sr-only">Close menu</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form class="mt-5"
            action="{{ route(request()->route()->action['as'], request()->route()->originalParameters()) }}"
            @submit.prevent="$el.querySelectorAll('input').forEach(item => {if (item.value == null || item.value == '') item.remove()});$el.submit()">
            @if ($sort = request()->sort)
                <input type="hidden" name="sort" value="{{ $sort }}">
            @endif

            {{ $slot }}

            <x-primary-button type="submit" class="w-full justify-center mt-6">{{ __('Apply') }}</x-primary-button>

            <a href="{{ route(request()->route()->action['as'], request()->route()->originalParameters()) }}">
                <x-secondary-button type="button"
                    class="w-full justify-center mt-2">{{ __('Reset') }}</x-secondary-button>
            </a>
        </form>
    </div>
</div>
