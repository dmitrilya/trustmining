<div class="relative w-full {{ isset($searchBlock) ? $searchBlock : 'max-w-md' }}" x-data="{ open: false, sugs: false }" @click.away="open = false">
    <div class="relative z-0 w-full group" @click="open = true">
        <input type="text" name="search" placeholder="{{ __('Find a miner, company or article...') }}"
            @input.debounce.1000ms="sugs = search($el.value, $refs.suggestionList, open)" autocomplete="off"
            class="block w-full text-sm placeholder:text-xs sm:placeholder:text-sm placeholder:text-slate-500 text-slate-950 bg-transparent border-slate-300 appearance-none dark:text-slate-50 {{ isset($border) ? $border : 'px-0 py-2.5 border-0 border-b-2' }} dark:border-slate-700 dark:focus:border-slate-600 focus:outline-none focus:ring-0 focus:border-slate-800 peer" />
    </div>

    <div role="listbox" style="display: none" x-show="open && sugs"
        class="absolute z-10 mt-1 w-full overflow-auto rounded-b-md bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 backdrop-blur-2xl text-base shadow-xl shadow-logo-color ring-1 ring-black/10 dark:ring-white/10 focus:outline-none sm:text-sm">
        <div class="relative select-none hover:bg-slate-100 dark:hover:bg-slate-800 ring-1 ring-inset ring-indigo-500 dark:ring-indigo-600">
            <a href="#" class="flex items-center text-sm py-2 px-3">
                <div class="w-full text-slate-600">{{ __('Blurb') }}</div>
                <div
                    class="ml-auto inline-flex items-center px-2 py-1 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-md text-xxs text-slate-800 dark:text-slate-300 uppercase shadow-sm shadow-logo-color transition ease-in-out duration-150">
                    {{ __('Company') }}</div>
            </a>
        </div>

        <ul x-ref="suggestionList"></ul>
    </div>
</div>
