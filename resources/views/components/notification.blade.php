@props(['href' => '#', 'type', 'date', 'pretext' => '', 'text'])

<a href="{{ $href }}" class="rounded-md block p-4{{ $href != '#' ? ' hover:bg-gray-200' : '' }}">
    <div class="flex items-center justify-between">
        <div class="text-gray-400 text-xs mr-2">{{ $type }}</div>
        <div class="date-transform text-xs leading-5 text-gray-500" data-date="{{ $date }}">
        </div>
    </div>

    <div class="font-semibold text-gray-900 mb-1">{{ $pretext }}</div>
    <div class="text-sm text-gray-500 max-h-10 overflow-hidden">{{ $text }}</div>
</a>
