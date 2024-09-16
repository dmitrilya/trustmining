<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $guide->title }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div
            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4 md:p-6 mb-6 space-y-4 sm:space-y-6 lg:space-y-8">
            <div class="flex items-center justify-between">
                <p class="date-transform text-xxs sm:text-xs font-normal text-gray-400" data-type="date"
                    data-date="{{ $guide->created_at }}"></p>

                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-600 dark:text-white" aria-hidden="true" width="24" height="24"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                            clip-rule="evenodd" />
                    </svg>

                    <p class="text-xxs sm:text-xs font-normal text-gray-400 ml-2">{{ $guide->views()->count() }}</p>
                </div>
            </div>
            <img src="{{ Storage::url('public/guides/' . $guide->id . '.webp') }}" alt=""
                class="rounded-lg w-full">
            {!! $guide->guide !!}
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 pb-8">
        <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @foreach ($guides as $guide)
                @php
                    switch ($loop->index) {
                        case 0:
                        case 1:
                            $classes = '!flex';
                            break;
                        case 2:
                            $classes = 'md:!flex';
                            break;
                        case 3:
                            $classes = 'lg:!flex';
                            break;
                        case 4:
                            $classes = 'xl-!flex';
                            break;
                    }
                @endphp

                <div
                    class="hidden {{ $classes }} bg-white shadow-md overflow-hidden rounded-lg flex-col justify-between">
                    @include('guide.components.card')
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
