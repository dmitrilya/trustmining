<x-filter>@include('ad.components.filter')</x-filter>

<fieldset aria-label="Choose a ad" class="w-full">
    <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @if ($owner)
            <a href="{{ route('ad.create') }}"
                class="cursor-pointer bg-gray-100 dark:bg-zinc-800 group hover:bg-white dark:hover:bg-zinc-900 sm:max-w-md p-2 h-full sm:px-4 sm:py-3 shadow-md overflow-hidden rounded-lg flex justify-center items-center border-2 border-dashed border-gray-400 dark:border-zinc-700">
                <div class="flex flex-col justify-center items-center">
                    <svg class="w-[72px] h-[72px] text-gray-300 dark:text-gray-400" aria-hidden="true" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2"
                            d="M16.5 15v1.5m0 0V18m0-1.5H15m1.5 0H18M3 9V6a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3M3 9v6a1 1 0 0 0 1 1h5M3 9h16m0 0v1M6 12h3m12 4.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                    </svg>

                    <div class="font-semibold text-xl text-gray-500 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 mt-2">
                        {{ __('Create') }}</div>
                </div>
            </a>
        @endif

        @foreach ($ads as $ad)
            @continue(!$owner && ($ad->moderation || $ad->hidden))

            @include('ad.components.card')
        @endforeach
    </div>
</fieldset>

<div class="mt-8 sm:mt-12 lg:mt-16">
    {{ $ads->links() }}
</div>
