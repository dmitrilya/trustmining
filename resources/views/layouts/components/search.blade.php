<div class="relative w-full {{ isset($searchBlock) ? $searchBlock : 'max-w-md' }}" x-data="{ open: false, sugs: false }" @click.away="open = false">
    <div class="relative z-0 w-full group" @click="open = true">
        <input type="text" placeholder="{{ __('Find a miner, company or article...') }}"
            @input.debounce.1000ms="sugs = search($el.value, $refs.suggestionList, open)" autocomplete="off"
            class="block w-full text-sm placeholder:text-xs sm:placeholder:text-sm placeholder:text-gray-500 text-gray-900 bg-transparent border-gray-300 appearance-none dark:text-gray-100 {{ isset($border) ? $border : 'px-0 py-2.5 border-0 border-b-2' }} dark:border-zinc-700 dark:focus:border-zinc-600 focus:outline-none focus:ring-0 focus:border-gray-800 peer" />
    </div>

    <div role="listbox" style="display: none" x-show="open && sugs"
        class="absolute z-10 mt-1 w-full overflow-auto rounded-b-md bg-white dark:bg-zinc-900 text-base shadow-xl ring-1 ring-black/10 dark:ring-white/10 focus:outline-none sm:text-sm">
        <div class="relative select-none hover:bg-gray-100 dark:hover:bg-zinc-800 ring-1 ring-inset ring-indigo-500 dark:ring-indigo-600">
            <a href="#" class="flex items-center text-sm py-2 px-3">
                <div class="w-full text-gray-500">{{ __('Blurb') }}</div>
                <div
                    class="ml-auto inline-flex items-center px-2 py-1 bg-gray-50 dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-md text-xxs text-gray-700 dark:text-gray-400 uppercase shadow-sm transition ease-in-out duration-150">
                    {{ __('Company') }}</div>
            </a>
        </div>

        <ul x-ref="suggestionList"></ul>
    </div>
</div>
