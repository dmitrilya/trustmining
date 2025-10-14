@props(['name', 'forName' => $name . '[]', 'items' => []])

<div {{ $attributes->merge(['class' => 'bg-gray-100 dark:bg-zinc-800 p-3 rounded-lg space-y-3']) }}>
    {{ $slot }}

    <div class="space-y-1">
        @foreach ($items as $item)
            <div class="flex">
                <x-text-input :id="$name" :name="$forName" type="text" :value="$item" class="py-1 px-2 mt-0" />

                <button type="button" class="text-indigo-400 text-sm hover:text-indigo-600" @click="$el.parentElement.remove()">
                    <svg class="h-5 w-5 ms-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" />
                    </svg>
                </button>
            </div>
        @endforeach
    </div>

    <button type="button" class="flex text-indigo-400 text-sm hover:text-indigo-600" @click='$el.previousElementSibling.insertAdjacentHTML("beforeEnd", `<div class="flex">
        <x-text-input :id="$name" :name="$forName" type="text" class="py-1 px-2 mt-0" />

        <button type="button" class="text-indigo-400 text-sm hover:text-indigo-600" @click="$el.parentElement.remove()">
            <svg class="h-5 w-5 ms-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" />
            </svg>
        </button>
    </div>`)'>
        <svg class="h-5 w-5 me-3" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path
                d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
        </svg>

        <span>{{ __('Add') }}</span>
    </button>
</div>
