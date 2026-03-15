<x-app-layout title="Встроить калькулятор майнинга и виджет сложности на сайт — Документация и API | TRUSTMINING"
    description="Добавьте интерактивные инструменты для майнеров на свой ресурс. Настраиваемые блоки характеристик, расчет окупаемости и актуальная сложность сети. Инструкция по использованию iframe-виджетов и кастомизации параметров">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight">
            {{ __('Widjets') }}
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8 space-y-8 lg:space-y-12">
        <div class="max-w-xs lg:max-w-xl mx-auto mt-4 md:mt-8">
            <h2 class="text-center text-2xl sm:text-3xl lg:text-5xl text-slate-900 dark:text-slate-100 font-bold">
                {{ __('Income calculator') }}
            </h2>
        </div>

        <div class="max-w-sm md:max-w-2xl mx-auto">
            <h3 class="text-center text-xs sm:text-lg lg:text-xl text-slate-500">
                {{ __('Customize the profitability calculator widget and embed it on your website in just one minute') }}
            </h3>
        </div>

        <div x-data="{
            screen: 430,
            theme: 'dark',
            blocks: ['additional-params', 'currency', 'coins', 'characteristics'],
            toggleBlock(item) {
                if (this.blocks.includes(item)) {
                    this.blocks = this.blocks.filter(b => b !== item);
                } else {
                    this.blocks.push(item);
                }
            },
            get scale() {
                const scale = $el.clientWidth / this.screen
                return scale > 1 ? 1 : scale;
            }
        }">
            <div class="grid grid-cols-1 md:grid-cols-2 justify-center gap-2 md:gap-4 max-w-4xl mx-auto">
                <div class="w-full md:w-md max-w-md mx-auto">
                    <div class="flex p-1 bg-slate-50 dark:bg-slate-900 rounded-xl w-full">
                        <button @click="screen = 430"
                            :class="screen === 430 ? 'bg-white dark:bg-slate-800 shadow-md' : 'opacity-50'"
                            class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Mobile') }}</button>
                        <button @click="screen = 768"
                            :class="screen === 768 ? 'bg-white dark:bg-slate-800 shadow-md' : 'opacity-50'"
                            class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Tablet') }}</button>
                        <button @click="screen = 1280"
                            :class="screen === 1280 ? 'bg-white dark:bg-slate-800 shadow-md' : 'opacity-50'"
                            class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Desktop') }}</button>
                    </div>
                    <div class="mt-2 flex p-1 bg-slate-50 dark:bg-slate-900 rounded-xl w-full">
                        <button @click="theme = 'light'"
                            :class="theme === 'light' ? 'bg-white dark:bg-slate-800 shadow-md' : 'opacity-50'"
                            class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Light') }}</button>
                        <button @click="theme = 'dark'"
                            :class="theme === 'dark' ? 'bg-white dark:bg-slate-800 shadow-md' : 'opacity-50'"
                            class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Dark') }}</button>
                    </div>
                    <div class="mt-2 grid grid-cols-2 gap-2 w-full">
                        <template
                            x-for="(item, key) in {'additional-params': '{{ __('Add. settings') }}', 'currency': '{{ __('Currency') }}', 'coins': '{{ __('Coins') }}', 'characteristics': '{{ __('Characteristics') }}'}">
                            <button @click="toggleBlock(key)"
                                class="flex items-center justify-between px-3 py-2 text-xs font-semibold rounded-xl border transition-all duration-200"
                                :class="blocks.includes(key) ?
                                    'bg-blue-50 border-blue-200 text-blue-700 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-300' :
                                    'bg-white border-slate-200 text-slate-500 opacity-60 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400'">

                                <span x-text="item"></span>

                                <svg x-show="blocks.includes(key)" class="w-4 h-4" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </template>
                    </div>
                </div>
                <div class="w-full md:w-md max-w-md mx-auto">
                    <div
                        class="h-full flex items-start group border p-2 sm:p-4 border-slate-300 dark:border-slate-700 rounded-xl">
                        <div class="break-all" x-text='`<script src="https://trustmining.ru/build/assets/calculator-widjet.js" data-theme="${theme}"
                            data-blocks="${blocks.join(",")}" data-model="antminer-l9" data-version="17"></script>`'></div>

                        <svg @click="navigator.clipboard.writeText($el.previousElementSibling.innerText)
                            .then(() => pushToastAlert('{{ __('Code successfully copied') }}', 'success'))"
                            class="cursor-pointer min-w-5 size-5 ml-3 sm:ml-4" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M18 3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1V9a4 4 0 0 0-4-4h-3a1.99 1.99 0 0 0-1 .267V5a2 2 0 0 1 2-2h7Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M8 7.054V11H4.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 8 7.054ZM10 7v4a2 2 0 0 1-2 2H4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <div itemscope itemtype="https://schema.org/ViewAction" class="mt-4 sm:mt-6 lg:mt-8 flex">
                <iframe id="calc-widjet_preview" class="mx-auto max-w-full rounded-xl overflow-hidden"
                    :src="`https://trustmining.ru/api/calculator-widjet?blocks=${blocks.join(',')}&theme=${theme}&model=antminer-t21&version=190`"
                    frameborder="0"
                    :style="`min-width: ${screen}px; width: ${screen}px; overflow: hidden; border: none; display: block; transform: scale(${scale});transform-origin: top left`"></iframe>

                <script>
                    window.addEventListener('message', function(event) {
                        if (event.data && event.data.type === 'resize-calculator') {
                            document.querySelector('#calc-widjet_preview').style.height = event.data.height + 'px';
                        }
                    }, false);
                </script>
            </div>
        </div>

        <div class="max-w-xs lg:max-w-xl mx-auto mt-4 md:mt-8">
            <h2 class="text-center text-2xl sm:text-3xl lg:text-5xl text-slate-900 dark:text-slate-100 font-bold">
                {{ __('Network difficulty') }}
            </h2>
        </div>

        <div class="max-w-sm md:max-w-2xl mx-auto">
            <h3 class="text-center text-xs sm:text-lg lg:text-xl text-slate-500">
                {{ __('Customize the network difficulty widget and embed it on your website in just one minute') }}
            </h3>
        </div>

        <div x-data="{
            screen: 430,
            theme: 'dark',
            blocks: ['period', 'prediction', 'graph', 'history'],
            toggleBlock(item) {
                if (this.blocks.includes(item)) {
                    this.blocks = this.blocks.filter(b => b !== item);
                } else {
                    this.blocks.push(item);
                }
            },
            get scale() {
                const scale = $el.clientWidth / this.screen
                return scale > 1 ? 1 : scale;
            }
        }">
            <div class="grid grid-cols-1 md:grid-cols-2 justify-center gap-2 md:gap-4 max-w-4xl mx-auto">
                <div class="w-full md:w-md max-w-md mx-auto">
                    <div class="flex p-1 bg-slate-50 dark:bg-slate-900 rounded-xl w-full">
                        <button @click="screen = 430"
                            :class="screen === 430 ? 'bg-white dark:bg-slate-800 shadow-md' : 'opacity-50'"
                            class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Mobile') }}</button>
                        <button @click="screen = 768"
                            :class="screen === 768 ? 'bg-white dark:bg-slate-800 shadow-md' : 'opacity-50'"
                            class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Tablet') }}</button>
                        <button @click="screen = 1280"
                            :class="screen === 1280 ? 'bg-white dark:bg-slate-800 shadow-md' : 'opacity-50'"
                            class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Desktop') }}</button>
                    </div>
                    <div class="mt-2 flex p-1 bg-slate-50 dark:bg-slate-900 rounded-xl w-full">
                        <button @click="theme = 'light'"
                            :class="theme === 'light' ? 'bg-white dark:bg-slate-800 shadow-md' : 'opacity-50'"
                            class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Light') }}</button>
                        <button @click="theme = 'dark'"
                            :class="theme === 'dark' ? 'bg-white dark:bg-slate-800 shadow-md' : 'opacity-50'"
                            class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Dark') }}</button>
                    </div>
                    <div class="mt-2 grid grid-cols-2 gap-2 w-full">
                        <template
                            x-for="(item, key) in {'period': '{{ __('Period') }}', 'prediction': '{{ __('Prediction') }}', 'graph': '{{ __('Graph') }}', 'history': '{{ __('History') }}'}">
                            <button @click="toggleBlock(key)"
                                class="flex items-center justify-between px-3 py-2 text-xs font-semibold rounded-xl border transition-all duration-200"
                                :class="blocks.includes(key) ?
                                    'bg-blue-50 border-blue-200 text-blue-700 dark:bg-blue-900/30 dark:border-blue-800 dark:text-blue-300' :
                                    'bg-white border-slate-200 text-slate-500 opacity-60 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400'">

                                <span x-text="item"></span>

                                <svg x-show="blocks.includes(key)" class="w-4 h-4" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </template>
                    </div>
                </div>
                <div class="w-full md:w-md max-w-md mx-auto">
                    <div
                        class="h-full flex items-start group border p-2 sm:p-4 border-slate-300 dark:border-slate-700 rounded-xl">
                        <div class="break-all" x-text='`<script src="https://trustmining.ru/build/assets/difficulty-widjet.js" data-theme="${theme}"
                            data-blocks="${blocks.join(",")}"></script>`'></div>

                        <svg @click="navigator.clipboard.writeText($el.previousElementSibling.innerText)
                            .then(() => pushToastAlert('{{ __('Code successfully copied') }}', 'success'))"
                            class="cursor-pointer min-w-5 size-5 ml-3 sm:ml-4" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M18 3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1V9a4 4 0 0 0-4-4h-3a1.99 1.99 0 0 0-1 .267V5a2 2 0 0 1 2-2h7Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M8 7.054V11H4.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 8 7.054ZM10 7v4a2 2 0 0 1-2 2H4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
