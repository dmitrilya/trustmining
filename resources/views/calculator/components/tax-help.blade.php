<div class="relative inline-block" x-data="{ open: false }" @mouseover="open = true" @mouseleave="open = false" @click="open = !open" @click.away="open = false">
    <div
        class="ml-1 sm:ml-2 flex items-center text-xs sm:text-sm text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 cursor-pointer transition-colors duration-150">
        <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M9.529 9.988a2.502 2.502 0 1 1 5 .191A2.441 2.441 0 0 1 12 12.582V14m-.01 3.008H12M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <span class="ml-1 sm:ml-2 border-b border-dashed border-slate-400 hover:border-slate-700 dark:hover:border-slate-300">
            {{ __('How is tax calculated?') }}
        </span>
    </div>

    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" style="display: none"
        class="absolute w-64 sm:w-96 top-6 left-0 p-2 sm:p-4 bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-slate-300 dark:border-slate-700 shadow-lg shadow-logo-color rounded-xl z-20">
        <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 border-b border-slate-300 dark:border-slate-700 pb-2 mb-3">
            {{ __('Mining taxation guide') }}
        </h3>
        <div class="space-y-2">
            <!-- Физические лица -->
            <div class="space-y-1">
                <div class="flex items-center text-xs font-bold text-indigo-500 bg-indigo-50 dark:bg-indigo-950/40 py-1 rounded-md">
                    <span class="mr-1.5">👤</span> {{ __('Individuals (excluding IE)') }}
                </div>
                <ul class="text-xxs sm:text-xs text-slate-600 dark:text-slate-400 space-y-1 pt-1 list-disc list-inside">
                    <li>{{ __('Personal income tax rate') }}: <strong class="text-slate-800 dark:text-slate-200">13%–22%</strong>
                        ({{ __('progressive scale') }})</li>
                    <li><strong class="text-slate-800 dark:text-slate-200">{{ __('Important') }}:</strong>
                        {{ __('Power consumption limit') }} - <span class="underline">6000 {{ __('kWh/month') }}</span></li>
                </ul>
            </div>

            <!-- ИП на ОСНО -->
            <div class="space-y-1">
                <div class="flex items-center text-xs font-bold text-emerald-500 bg-emerald-50 dark:bg-emerald-950/40 py-1 rounded-md">
                    <span class="mr-1.5">💼</span>
                    {{ __('IE (OSNO)') }}
                </div>
                <ul class="text-xxs sm:text-xs text-slate-600 dark:text-slate-400 space-y-1 pt-1 list-disc list-inside">
                    <li>{{ __('Personal income tax rate') }}: <strong class="text-slate-800 dark:text-slate-200">13%–22%</strong>
                        ({{ __('progressive scale') }})</li>
                    <li><strong class="text-slate-800 dark:text-slate-200">{{ __('Expenses') }}:</strong>
                        {{ __('Professional tax deduction allowed') }} ({{ __('st. 221 NK RF') }})</li>
                </ul>
            </div>

            <!-- Запрет спецрежимов (Вместо старого ИП на УСН) -->
            <div class="space-y-1">
                <div class="flex items-center text-xs font-bold text-rose-500 bg-rose-50 dark:bg-rose-950/40 py-1 rounded-md">
                    <span class="mr-1.5">⛔</span> {{ __('Special tax regimes') }}
                </div>
                <ul class="text-xxs sm:text-xs text-slate-600 dark:text-slate-400 space-y-1 pt-1 list-disc list-inside">
                    <li><strong class="text-rose-600 font-semibold">{{ __('STS / Patent / Self-employment') }}:</strong> <span
                            class="text-rose-600 font-bold">{{ __('PROHIBITED') }}</span></li>
                    <li>{{ __('All business miners are required to use OSNO') }}</li>
                </ul>
            </div>

            <!-- Юрлица на ОСНО -->
            <div class="space-y-1">
                <div class="flex items-center text-xs font-bold text-blue-500 bg-blue-50 dark:bg-blue-950/40 py-1 rounded-md">
                    <span class="mr-1.5">🏢</span>
                    {{ __('Legal entities (OSNO)') }}
                </div>
                <ul class="text-xxs sm:text-xs text-slate-600 dark:text-slate-400 space-y-1 pt-1 list-disc list-inside">
                    <li><strong class="text-slate-800 dark:text-slate-200">{{ __('Income tax') }}: 25%</strong> ({{ __('8% federal, 17% regional') }})</li>
                    <li><strong class="text-slate-800 dark:text-slate-200">{{ __('VAT') }}: 0%</strong>
                        ({{ __('exempt under st. 146 NK RF, no deductions') }})</li>
                </ul>
            </div>

            <!-- Учет оборудования (Вместо старого Юрлица на УСН) -->
            <div class="space-y-1">
                <div class="flex items-center text-xs font-bold text-amber-500 bg-amber-50 dark:bg-amber-950/40 py-1 rounded-md">
                    <span class="mr-1.5">⚙️</span>
                    {{ __('Asset & Equipment Accounting') }}
                </div>
                <ul class="text-xxs sm:text-xs text-slate-600 dark:text-slate-400 space-y-1 pt-1 list-disc list-inside">
                    <li><strong class="text-slate-800 dark:text-slate-200">{{ __('Depreciation') }}:</strong> {{ __('3rd group, useful life 3–5 years') }}
                    </li>
                    <li><strong class="text-slate-800 dark:text-slate-200">{{ __('Property tax') }}: {{ __('up to') }} 2.2%</strong>
                        ({{ __('depends on region') }})</li>
                </ul>
            </div>

            <!-- Кнопка перехода -->
            <div class="pt-2 mt-2 text-center border-t border-slate-300 dark:border-slate-700">
                <a href="{{ route('tax') }}"
                    class="inline-flex items-center text-xs font-semibold text-indigo-500 hover:text-indigo-600 group transition-colors duration-150">
                    <span>{{ __('More details with calculation examples') }}</span>
                    <svg class="w-3.5 h-3.5 ml-1 transform group-hover:translate-x-0.5 transition-transform duration-150" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
