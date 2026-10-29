<template x-if="openedSearch">
    <div x-show="openSearch" x-collapse class="w-full overflow-hidden">
        <div class="pt-4 pb-4 sm:pb-6" x-data="search()">
            <h2 class="text-xs text-slate-500 uppercase tracking-widest mb-4">
                {{ __('SEARCH BY TRUSTMINING') }}
            </h2>

            <div
                class="group relative flex items-center max-w-sm p-3 mt-1 w-full rounded-xl shadow shadow-logo-color border-0 ring-1 ring-inset! ring-slate-300 dark:ring-slate-700 focus:ring-indigo-500 dark:focus:ring-emerald-500/50 focus:outline-none">
                <input x-ref="searchInput" type="text" autocomplete="off" x-model="query" id="tm_search"
                    placeholder="{{ __('Find a miner, company or article...') }}" @input.debounce.300ms="search()" @keydown.escape="clear()"
                    class="peer block w-full border-0 bg-transparent p-0 text-sm text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-0" />

                <svg x-show="loading" x-cloak class="ml-3 h-4 w-4 shrink-0 animate-spin text-indigo-500" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-80" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                </svg>

                <button x-show="query.length" x-cloak type="button" aria-label="{{ __('Clear search') }}"
                    class="ml-4 flex h-4 w-4 shrink-0 items-center justify-center rounded-md text-slate-500"
                    @click="clear(); $nextTick(() => $refs.searchInput.focus())">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div x-show="query.trim().length > 0" x-cloak class="mt-4 overflow-hidden">
                <div x-show="categories.length > 0" class="flex gap-2 mb-3 overflow-x-auto" role="tablist" aria-label="{{ __('Search categories') }}">
                    <template x-for="category in categories" :key="category">
                        <button type="button" @click="activeCategory = category"
                            :class="activeCategory === category ?
                                'bg-indigo-200 dark:bg-indigo-600 border-indigo-500 dark:border-indigo-700 text-indigo-500' :
                                'border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-700 text-slate-800 group-hover:text-indigo-600'"
                            class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 group border rounded-xl dark:text-slate-200" role="tab"
                            :aria-selected="activeCategory === category">
                            <span x-text="suggestions[category].label"></span>

                            <span class="ml-1.5 rounded-md bg-slate-200 dark:bg-slate-800 px-1.5 py-0.5 text-xs text-slate-600 dark:text-slate-400"
                                x-text="suggestions[category].items.length"></span>
                        </button>
                    </template>
                </div>

                <div x-show="categories.length > 0" x-ref="suggestionList" class="max-h-[min(55vh,480px)] overflow-y-auto" role="tabpanel">
                    <template x-for="(item, index) in activeItems" :key="item.href ?? `${activeCategory}-${index}`">
                        <a :href="item.href" class="group flex mr-2 sm:mr-4 items-center gap-3 rounded-xl py-2">
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                <template x-if="item.icon">
                                    <img :src="item.icon" :alt="item.name" class="h-full w-full object-contain p-1.5" loading="lazy" />
                                </template>

                                <template x-if="!item.icon">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <path d="M4 5h16v14H4z"></path>
                                        <path d="M8 9h8M8 13h5"></path>
                                    </svg>
                                </template>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="truncate text-sm font-medium text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-emerald-400"
                                    x-text="item.name"></div>

                                <div class="mt-1 text-xs text-slate-600 dark:text-slate-400" x-text="item.caption"></div>
                            </div>

                            <svg class="h-4 w-4 shrink-0 text-slate-600 dark:text-slate-400 transition group-hover:text-indigo-600 dark:group-hover:text-emerald-400"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path d="M7 17 17 7M7 7h10v10"></path>
                            </svg>
                        </a>
                    </template>
                </div>

                <div x-show="loading && categories.length === 0" class="px-4 py-10 text-center text-sm text-slate-600 dark:text-slate-400">
                    {{ __('Searching...') }}
                </div>

                <div x-show="!loading && categories.length === 0" class="px-4 py-10 text-center">
                    <div
                        class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="m16 16 4 4"></path>
                        </svg>
                    </div>

                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">
                        {{ __('Nothing found') }}
                    </p>

                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-400">
                        {{ __('Try another search query') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
