<div class="flex">
    <x-filter>@include('notification.components.filter')</x-filter>

    <div class="w-full bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg p-2 sm:p-4 md:p-6">
        @if (!$notifications->count())
            <p class="text-base text-gray-500">
                {{ __('No notifications yet') }}
            </p>
        @else
            <ul role="list" class="divide-y divide-gray-200 dark:divide-zinc-700">
                @include('notification.components.foreach')
            </ul>

            {{ $notifications->links() }}
        @endif
    </div>
</div>
