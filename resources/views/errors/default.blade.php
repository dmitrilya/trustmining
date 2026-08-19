<x-app-layout noindex="true" :title='__("errors.default.$code.title")'>
    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 md:p-8">
        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 lg:p-14">

            <div class="mx-auto md:grid md:grid-cols-12 md:grid-rows-[auto,auto,1fr] md:gap-x-8 offer-card">
                <div class="md:col-span-5">
                    <div class="h-full flex flex-col justify-between">
                        <div class="flex gap-2" x-data="{ active: 0 }">
                            <div class="min-w-16 w-16 flex flex-col gap-2">
                                <div class="w-full aspect-[4/3] rounded-lg cursor-pointer transition ring-2 ring-indigo-500">
                                    <img src="/img/errors/{{ $code }}.webp" alt="error {{ $code }}"
                                        class="w-full h-full rounded-lg object-cover">
                                </div>
                            </div>

                            <div class="relative w-full aspect-[4/3] rounded-lg overflow-hidden bg-slate-100">
                                <div class="absolute inset-0">
                                    <img src="/img/errors/{{ $code }}.webp" alt="error {{ $code }}" class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>

                        <div class="hidden md:block mt-4">
                            <x-characteristics.characteristics>
                                <x-characteristics.characteristic :name="__('errors.default.' . $code . '.characteristic_1.name')" :value="__('errors.default.' . $code . '.characteristic_1.value')" />
                                <x-characteristics.characteristic :name="__('errors.default.' . $code . '.characteristic_2.name')" :value="__('errors.default.' . $code . '.characteristic_2.value')" />
                                <x-characteristics.characteristic :name="__('errors.default.' . $code . '.characteristic_3.name')" :value="__('errors.default.' . $code . '.characteristic_3.value')" />
                                <x-characteristics.characteristic :name="__('errors.default.' . $code . '.characteristic_4.name')" :value="__('errors.default.' . $code . '.characteristic_4.value')" />
                            </x-characteristics.characteristics>
                        </div>
                    </div>
                </div>

                <div class="mt-4 sm:mt-8 md:mt-0 md:col-span-7 md:border-l border-slate-300 dark:border-slate-700 md:pl-8">
                    <div class="flex items-start justify-between">
                        <h1 itemprop="name" class="text-xl font-bold tracking-tight text-slate-800 dark:text-slate-200 sm:text-2xl md:text-3xl">
                            {{ __("errors.default.$code.name") }}
                        </h1>
                    </div>

                    <div>
                        <p class="mt-5 text-2xl font-semibold text-slate-800 dark:text-slate-200 flex items-center">
                            <span>{{ $code }}</span>
                            <span class="ml-2">RUB</span>
                            <span class="ml-1 text-xs sm:text-sm lg:text-base">({{ __('The price includes VAT') }})</span>
                        </p>

                        <a href="#"
                            class="flex items-center hover:underline text-xxs xxs:text-xs sm:text-sm sm:text-base text-indigo-500 hover:text-indigo-600 mt-2 sm:mt-3 md:mt-4 lg:mt-6">
                            <svg class="w-5 h-5 mr-2" aria-hidden="true" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ __('errors.default.address') }}
                        </a>

                        <x-characteristics.characteristics class="my-5 sm:my-6 lg:my-7">
                            <x-characteristics.characteristic :name="__('errors.default.' . $code . '.characteristic_5.name')" :value="__('errors.default.' . $code . '.characteristic_5.value')" />
                            <x-characteristics.characteristic :name="__('errors.default.' . $code . '.characteristic_6.name')" :value="__('errors.default.' . $code . '.characteristic_6.value')" />
                            <x-characteristics.characteristic :name="__('errors.default.' . $code . '.characteristic_7.name')" :value="__('errors.default.' . $code . '.characteristic_7.value')" />
                            <x-characteristics.characteristic :name="__('errors.default.' . $code . '.characteristic_8.name')" :value="__('errors.default.' . $code . '.characteristic_8.value')" />
                        </x-characteristics.characteristics>
                    </div>
                </div>
            </div>

            <div class="mt-8" x-data="{ selectedTab: 'description' }">
                <div
                    class="mb-6 sm:mb-8 lg:mb-10 text-xs sm:text-sm text-center text-slate-600 border-b border-slate-300 dark:text-slate-400 dark:border-slate-800">
                    <ul class="flex flex-wrap -mb-px">
                        <li class="mr-0.5 sm:mr-2">
                            <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg" @click="selectedTab = 'description'"
                                :class="{
                                    'border-transparent hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-slate-600': 'description' !=
                                        selectedTab,
                                    'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'description' ==
                                        selectedTab
                                }">
                                {{ __('Description') }}
                            </button>
                        </li>
                        <li class="mr-0.5 sm:mr-2 md:hidden">
                            <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg" @click="selectedTab = 'characteristics'"
                                :class="{
                                    'border-transparent hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-slate-600': 'characteristics' !=
                                        selectedTab,
                                    'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'characteristics' ==
                                        selectedTab
                                }">
                                {{ __('Characteristics') }}
                            </button>
                        </li>
                    </ul>
                </div>

                <div x-show="selectedTab == 'description'">
                    <div>
                        <h2 class="font-extrabold tracking-tight text-slate-800 dark:text-slate-200">
                            {{ __('Ad description') }}</h2>

                        <div class="mt-5 text-xs sm:text-sm sm:text-base text-slate-600 dark:text-slate-400 space-y-2 sm:space-y-4">
                            @if (Lang::has("errors.default.$code.paragraphs"))
                                @foreach (trans("errors.default.$code.paragraphs") as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            @else
                                <p>{{ __('An unexpected error occurred.') }}</p>
                            @endif
                        </div>
                    </div>

                </div>

                <div x-show="selectedTab == 'characteristics'" style="display: none">
                    <x-characteristics.characteristics>
                        <x-characteristics.characteristic :name="__('errors.default.' . $code . '.characteristic_1.name')" :value="__('errors.default.' . $code . '.characteristic_1.value')" />
                        <x-characteristics.characteristic :name="__('errors.default.' . $code . '.characteristic_2.name')" :value="__('errors.default.' . $code . '.characteristic_2.value')" />
                        <x-characteristics.characteristic :name="__('errors.default.' . $code . '.characteristic_3.name')" :value="__('errors.default.' . $code . '.characteristic_3.value')" />
                        <x-characteristics.characteristic :name="__('errors.default.' . $code . '.characteristic_4.name')" :value="__('errors.default.' . $code . '.characteristic_4.value')" />
                    </x-characteristics.characteristics>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
