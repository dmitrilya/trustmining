<div class="sticky top-0 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-lg shadow-logo-color rounded-lg p-4 z-10">
    <div class="flex max-w-max bg-slate-100 dark:bg-slate-900 rounded-s-lg rounded-e-lg overflow-hidden border dark:border-slate-700 h-7 sm:h-8">
        <div @click="changePeriod('1d');"
            :class="{
                'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                    '1d',
                ' text-slate-700 dark:text-slate-200': period != '1d'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
            {{ '1' . __('d') }}
        </div>
        <div @click="changePeriod('3d');"
            :class="{
                'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                    '3d',
                ' text-slate-700 dark:text-slate-200': period != '3d'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
            {{ '3' . __('d') }}
        </div>
        <div @click="changePeriod('1w');"
            :class="{
                'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                    '1w',
                ' text-slate-700 dark:text-slate-200': period != '1w'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
            {{ '1' . __('w') }}
        </div>
        <div @click="changePeriod('1m');"
            :class="{
                'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                    '1m',
                ' text-slate-700 dark:text-slate-200': period != '1m'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
            {{ '1' . __('m') }}
        </div>
        <div @click="changePeriod('3m');"
            :class="{
                'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                    '3m',
                ' text-slate-700 dark:text-slate-200': period != '3m'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
            {{ '3' . __('m') }}
        </div>
        <div @click="changePeriod('1y');"
            :class="{
                'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                    '1y',
                ' text-slate-700 dark:text-slate-200': period != '1y'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
            {{ '1' . __('y') }}
        </div>
        <div @click="changePeriod('all');"
            :class="{
                'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                    'all',
                ' text-slate-700 dark:text-slate-200': period != 'all'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
            {{ __('All') }}
        </div>
    </div>
</div>
