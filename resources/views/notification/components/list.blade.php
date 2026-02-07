<div class="flex">
    <x-filter>@include('notification.components.filter')</x-filter>

    <div class="w-full bg-white/60 dark:bg-zinc-900/60 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6">
        @if (!$notifications->count())
            <p class="text-base text-gray-600">
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
