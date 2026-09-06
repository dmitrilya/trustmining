<section class="mt-4 sm:mt-6 lg:mt-8">
    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
        <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
            {{ __('What makes the TrustMining mining calculator different?') }}
        </h2>
    </div>

    <div class="px-2 sm:px-3 mb-4 sm:mb-5">
        <p class="text-xs xs:text-sm text-slate-600 dark:text-slate-400">
            {{ __('The TrustMining mining calculator does more than estimate the current income of an ASIC. It calculates net mining profit, expenses and payback period using current network data, electricity costs, equipment prices and additional parameters that affect the real economics of mining.') }}
        </p>

        <p class="text-xs xs:text-sm text-slate-600 dark:text-slate-400 mt-2">
            {{ __('You can compare all profitable coins available for your ASIC, account for taxes and equipment depreciation, evaluate different firmware options and see how much the selected firmware can change your mining profit.') }}
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
        <div class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 p-2 sm:p-3">
            <div class="flex items-center gap-2 mb-2 lg:mb-4">
                <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                    </svg>
                </div>

                <div>
                    <h3 class="font-bold text-sm sm:text-base text-slate-800 dark:text-slate-200">
                        {{ __('Net mining profit calc') }}
                    </h3>
                </div>
            </div>

            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                {{ __('Calculates net revenue, pool fees and power costs for the selected ASIC miner') }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 p-2 sm:p-3">
            <div class="flex items-center gap-2 mb-2 lg:mb-4">
                <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-blue-500/10 text-blue-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                    </svg>
                </div>

                <div>
                    <h3 class="font-bold text-sm sm:text-base text-slate-800 dark:text-slate-200">
                        {{ __('All mineable crypto coins') }}
                    </h3>
                </div>
            </div>

            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                {{ __('Scans all mineable coins on the selected algorithm and sorts them by profitability') }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 p-2 sm:p-3">
            <div class="flex items-center gap-2 mb-2 lg:mb-4">
                <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-amber-500/10 text-amber-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                    </svg>
                </div>

                <div>
                    <h3 class="font-bold text-sm sm:text-base text-slate-800 dark:text-slate-200">
                        {{ __('Electricity cost setup') }}
                    </h3>
                </div>
            </div>

            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                {{ __('Set your power tariff and equipment uptime to calculate real monthly mining costs') }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 p-2 sm:p-3">
            <div class="flex items-center gap-2 mb-2 lg:mb-4">
                <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-violet-500/10 text-violet-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>

                <div>
                    <h3 class="font-bold text-sm sm:text-base text-slate-800 dark:text-slate-200">
                        {{ __('Mining tax calculations') }}
                    </h3>
                </div>
            </div>

            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                {{ __('Calculates mining taxes based on selected settings and hardware depreciation rate') }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 p-2 sm:p-3">
            <div class="flex items-center gap-2 mb-2 lg:mb-4">
                <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-cyan-500/10 text-cyan-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zM14.25 15h.008v.008H14.25V15zm0 2.25h.008v.008H14.25v-.008zM16.5 15h.008v.008H16.5V15zm0 2.25h.008v.008H16.5v-.008zM14.25 12.75h.008v.008H14.25v-.008zM16.5 12.75h.008v.008H16.5v-.008z" />
                    </svg>
                </div>

                <div>
                    <h3 class="font-bold text-sm sm:text-base text-slate-800 dark:text-slate-200">
                        {{ __('ASIC payback period estimation') }}
                    </h3>
                </div>
            </div>

            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                {{ __('Estimates actual hardware payback period using live ASIC miner prices on TrustMining') }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 p-2 sm:p-3">
            <div class="flex items-center gap-2 mb-2 lg:mb-4">
                <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-pink-500/10 text-pink-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 3v1.5M4.5 8.25H3m1.5 3H3m1.5 3H3m16.5-6H18m1.5 3H18m1.5 3H18M21 12a9 9 0 11-18 0 9 9 0 0118 0zM15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                </div>

                <div>
                    <h3 class="font-bold text-sm sm:text-base text-slate-800 dark:text-slate-200">
                        {{ __('ASIC firmware profit analysis') }}
                    </h3>
                </div>
            </div>

            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                {{ __('Shows available ASIC firmware options and evaluates their impact on mining efficiency') }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 p-2 sm:p-3">
            <div class="flex items-center gap-2 mb-2 lg:mb-4">
                <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                    </svg>
                </div>

                <div>
                    <h3 class="font-bold text-sm sm:text-base text-slate-800 dark:text-slate-200">
                        {{ __('Live crypto network data') }}
                    </h3>
                </div>
            </div>

            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                {{ __('Monitors network difficulty and crypto prices in real time for accurate calculations') }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 p-2 sm:p-3">
            <div class="flex items-center gap-2 mb-2 lg:mb-4">
                <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-orange-500/10 text-orange-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a2.25 2.25 0 003.182 0l4.318-4.318a2.25 2.25 0 000-3.182L11.16 3.659A2.25 2.25 0 009.568 3zM6 6h.008v.008H6V6z" />
                    </svg>
                </div>

                <div>
                    <h3 class="font-bold text-sm sm:text-base text-slate-800 dark:text-slate-200">
                        {{ __('Current ASIC miner prices') }}
                    </h3>
                </div>
            </div>

            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                {{ __('Uses live equipment offers from TrustMining database to calculate exact mining ROI') }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 p-2 sm:p-3">
            <div class="flex items-center gap-2 mb-2 lg:mb-4">
                <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-teal-500/10 text-teal-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                </div>

                <div>
                    <h3 class="font-bold text-sm sm:text-base text-slate-800 dark:text-slate-200">
                        {{ __('Flexible mining parameters') }}
                    </h3>
                </div>
            </div>

            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                {{ __('Adjust uptime, pool fees and ASIC cost to build a customized mining profit calculation') }}
            </p>
        </div>
    </div>
</section>
