@props(['href' => '#', 'type', 'date', 'pretext' => '', 'text'])

<a href="{{ $href }}" class="rounded-md block p-4{{ $href != '#' ? ' hover:bg-gray-200 dark:hover:bg-zinc-800' : '' }}">
    <div class="flex items-center justify-between">
        <div class="text-gray-500 text-xxs sm:text-xs mr-2">{{ __($type) }}</div>
        <div class="date-transform text-xxs sm:text-xs leading-5 text-gray-600" data-date="{{ $date }}">
        </div>
    </div>

    <div class="font-semibold text-gray-950 dark:text-gray-100 mb-1">
        @if ($type != 'New review')
            {{ $pretext }}
        @else
            <div class="flex items-center" x-data="{ momentRating: {{ $pretext }} }">
                <x-rating></x-rating>
            </div>
        @endif
    </div>

    <div class="text-sm text-gray-600 max-h-10 overflow-hidden">{{ $text }}</div>
</a>
