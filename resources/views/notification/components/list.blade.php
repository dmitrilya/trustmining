<div class="flex">
    <x-filter>@include('notification.components.filter')</x-filter>

    <div class="w-full bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6">
        @if (!$notifications->count())
            <p class="text-base text-slate-600">
                {{ __('No notifications yet') }}
            </p>
        @else
            <ul role="list" class="divide-y divide-slate-200 dark:divide-slate-700">
                @include('notification.components.foreach')
            </ul>

            {{ $notifications->links() }}
        @endif
    </div>
</div>
