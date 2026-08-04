@props(['name', 'label', 'all', 'selected' => collect(), 'handleChange' => '', 'withAdding' => false])

<div x-data="{ all: {{ $all }}, selected: {{ $selected }}, search: '' }">
    <div>
        <x-inputs.input-label for="search" :value="__($label)" />

        @if (!$withAdding)
            <x-inputs.text-input id="search" type="text" x-model="search" :placeholder="__('Search')" autocomplete="off" />
        @else
            <div
                class="mt-1 flex items-center overflow-hidden bg-white dark:bg-slate-950 rounded-lg shadow-sm shadow-logo-color ring-1 ring-inset ring-slate-300 dark:ring-slate-700 focus-within:ring-indigo-500 dark:focus-within:ring-indigo-500 pr-2">
                <input type="text" id="search" x-model="search" :placeholder="__('Search')"
                    class="py-1.5 px-3 bg-transparent border-0 focus:ring-0 text-slate-600 dark:text-slate-400 w-full" />

                <button type="button"
                    class="text-xs bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 hover:dark:bg-slate-700 shadow-sm text-slate-600 dark:text-slate-400 px-2 py-1 rounded-full"
                    @click="if (!search.trim().length) return; selected.push(search); if (all.indexOf(search) != -1) all.splice(all.indexOf(search), 1); search = ''">{{ __('Add') }}</button>
            </div>
        @endif
    </div>

    <template x-if="selected.length">
        <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
            <template x-for="item in selected" :key="item">
                <div>
                    <div @click="selected.splice(selected.indexOf(item), 1); all.unshift(item); {{ $handleChange }}" x-text="item"
                        class="cursor-pointer px-1 py-0.5 xs:px-2 xs:py-1 rounded-md bg-indigo-600 hover:bg-indigo-500 dark:hover:bg-slate-800 text-white text-xxs xs:text-xs">
                    </div>
                    <input type="hidden" name="{{ $name }}[]" :value="item">
                </div>
            </template>
        </div>
    </template>

    <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
        <template x-for="item in all.filter(item => `${item.toLowerCase()}`.indexOf(search.toLowerCase()) !== -1).slice(0, 20)" :key="item">
            <div @click="selected.push(item); all.splice(all.indexOf(item), 1); search = ''; {{ $handleChange }}" x-text="item"
                class="cursor-pointer px-1 py-0.5 xs:px-2 xs:py-1 rounded-md bg-slate-50 dark:bg-slate-950 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-200 text-xxs xs:text-xs">
            </div>
        </template>
        <div x-show="all.filter(item => `${item.toLowerCase()}`.indexOf(search.toLowerCase()) !== -1).length > 20"
            class="px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-slate-50 dark:bg-slate-950 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-200 text-xxs sm:text-xs">
            {{ __('another') }} <span x-text="all.filter(item => `${item}`.indexOf(search) !== -1).length - 20"></span>
        </div>
    </div>
</div>
