@props(['name', 'items', 'field', 'type'])

<div class="{{ $field != 'algorithms' ? 'border-t ' : '' }}border-gray-200 dark:border-zinc-700 py-5" x-data="{ open: {{ request()->get($field) ? 'true' : 'false' }} }">
    <h3 class="-mx-2 -my-3 flow-root">
        <button type="button" @click="open = !open" x-bind:aria-expanded="open.toString()"
            class="flex w-full items-center justify-between bg-white dark:bg-zinc-900 px-2 py-3 text-gray-500 dark:text-gray-400 hover:text-gray-500 dark:hover:text-gray-400"
            aria-controls="filter-section-mobile-{{ $name }}" aria-expanded="false">
            <span class="text-gray-950 dark:text-gray-100">{{ $name }}</span>
            <span class="ml-6 flex items-center">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path
                        d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>

                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" />
                </svg>
            </span>
        </button>
    </h3>

    <div class="pt-6 max-h-40 overflow-y-auto" id="filter-section-mobile-{{ $name }}" x-show="open" style="display: none">
        <div class="space-y-3">
            @foreach ($items as $item)
                @if ($type == 'checkbox')
                    <x-checkbox :name="$field . '[]'" :value="$item['url_name']" textClasses="text-gray-600" :checked="request()->get($field) && in_array($item['url_name'], request()->get($field))">
                        {{ __($item['name']) }}
                    </x-checkbox>
                @else
                    <x-radio :name="$field" :value="$item['url_name']" textClasses="text-gray-600" :checked="request()->get($field) == $item['url_name']">
                        {{ __($item['name']) }}
                    </x-radio>
                @endif
            @endforeach
        </div>
    </div>
</div>
