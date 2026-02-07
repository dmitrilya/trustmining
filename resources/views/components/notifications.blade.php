@props(['notifications'])

<div class="w-5 h-5" x-data="{ open: false }">
    <button @click="open = ! open;checkNotifications()"  aria-label="{{ __('Notifications') }}"
        class="relative inline-flex items-center text-sm text-center text-gray-600 dark:text-zinc-500 hover:text-gray-500 dark:hover:text-zinc-400 focus:outline-none"
        type="button">
        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 14 20">
            <path
                d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z" />
        </svg>

        @if ($notifications->where('checked', false)->count())
            <div id="notifications-signal"
                class="absolute block w-3 h-3 bg-red-500 border-2 border-white rounded-full -top-0.5 start-2.5 dark:border-zinc-950">
            </div>
        @endif
    </button>

    <div x-show="open" class="absolute z-10 mt-5 flex max-w-sm md:max-w-md lg:max-w-lg right-2 sm:right-6 lg:right-8 overflow-hidden rounded-3xl backdrop-blur-2xl"
        style="width: calc(100vw - 1rem);display: none" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1" @click.away="open = false">
        <div
            class="w-full flex-auto bg-white/60 dark:bg-zinc-900/60 text-sm leading-6 shadow-lg shadow-logo-color ring-1 ring-gray-900/5">
            <div
                class="block px-4 py-2 text-center text-gray-800 rounded-t-lg bg-gray-50 dark:bg-zinc-900 dark:text-white">
                {{ __('Notifications') }}
            </div>
            <div class="divide-y divide-gray-100 dark:divide-zinc-800">
                @if (!$notifications->count())
                    <x-notification :type="__('No notifications yet')" :date="now()" :text="__('Notifications will be displayed here')"></x-notification>
                @else
                    @include('notification.components.foreach')
                @endif
            </div>
            <a href="{{ route('notifications') }}"
                class="block py-2 text-sm text-center text-gray-950 rounded-b-lg bg-gray-50 hover:bg-gray-100 dark:bg-zinc-900 dark:hover:bg-zinc-800 dark:text-white">
                <div class="inline-flex items-center ">
                    <svg class="w-4 h-4 me-2 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                        viewBox="0 0 20 14">
                        <path
                            d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                    </svg>
                    {{ __('View all') }}
                </div>
            </a>
        </div>
    </div>
</div>
