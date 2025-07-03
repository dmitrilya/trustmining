@props(['label', 'name', 'items', 'key' => null, 'icon' => null])

<div x-data="{ open: false, items: {{ $items }}, itemKey: {{ $key ? $key : $items->first()['key'] }} }">
    <x-input-label :value="$label" />
    <input type="hidden" name="{{ $name }}" :value="itemKey">

    <div class="relative mt-1 min-w-max">
        <button type="button" @click="open = ! open"
            class="relative w-full rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-indigo-500">
            <span class="flex items-center">
                @if ($icon)
                    @switch($icon['type'])
                        @case('value')
                            <img class="mr-2 xs:mr-3 w-4 h-4 xs:w-5 xs:h-5"
                                :src="'{{ $icon['path'] }}' + items[itemKey].value +
                                    '.webp'"
                                :alt="items[itemKey].value">
                        @break

                        @case('path')
                            <img class="mr-2 xs:mr-3 w-4 h-4 xs:w-5 xs:h-5" :src="items[itemKey].icon"
                                :alt="items[itemKey].value">
                        @break
                    @endswitch
                @endif

                <span class="block truncate" x-text="items[itemKey].value"></span>
            </span>
            <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" />
                </svg>
            </span>
        </button>

        <ul x-show="open" @click.away="open = false" style="display: none"
            class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
            @foreach ($items as $item)
                <li @click="itemKey = {{ $item['key'] }};open = false"
                    class="flex items-center justify-between cursor-default select-none py-2 px-3 text-gray-900 hover:bg-indigo-600 hover:text-white">
                    <div class="flex items-center w-full">
                        @if ($icon)
                            @switch($icon['type'])
                                @case('value')
                                    <img class="mr-2 xs:mr-3 w-4 h-4 xs:w-5 xs:h-5"
                                        src="{{ $icon['path'] . $item['value'] . '.webp' }}" alt="{{ $item['value'] }}">
                                @break

                                @case('path')
                                    <img class="mr-2 xs:mr-3 w-4 h-4 xs:w-5 xs:h-5" src="{{ $item->icon }}"
                                        alt="{{ $item['value'] }}">
                                @break
                            @endswitch
                        @endif

                        <span class="block truncate">{{ $item['value'] }}</span>
                    </div>

                    <span x-show="{{ $item['key'] }} == itemKey" class="flex items-center">
                        <svg class="h-4 w-4 min-w-4 ml-2 xs:ml-3" viewBox="0 0 20 20" fill="currentColor"
                            class="text-indigo-600 hover:text-white" aria-hidden="true">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" />
                        </svg>
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
