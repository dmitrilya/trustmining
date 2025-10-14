<div class="sticky top-0 bg-white dark:bg-zinc-900 overflow-hidden shadow-lg rounded-lg p-4 z-10">
    <div class="flex max-w-max bg-gray-100 dark:bg-zinc-800 rounded-s-lg rounded-e-lg overflow-hidden border h-7 sm:h-8">
        <div @click="changePeriod('1d');"
            :class="{
                'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-zinc-700': period ==
                    '1d',
                ' text-gray-600 dark:text-gray-300': period != '1d'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-zinc-600">
            {{ '1' . __('d') }}
        </div>
        <div @click="changePeriod('3d');"
            :class="{
                'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-zinc-700': period ==
                    '3d',
                ' text-gray-600 dark:text-gray-300': period != '3d'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-zinc-600">
            {{ '3' . __('d') }}
        </div>
        <div @click="changePeriod('1w');"
            :class="{
                'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-zinc-700': period ==
                    '1w',
                ' text-gray-600 dark:text-gray-300': period != '1w'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-zinc-600">
            {{ '1' . __('w') }}
        </div>
        <div @click="changePeriod('1m');"
            :class="{
                'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-zinc-700': period ==
                    '1m',
                ' text-gray-600 dark:text-gray-300': period != '1m'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-zinc-600">
            {{ '1' . __('m') }}
        </div>
        <div @click="changePeriod('3m');"
            :class="{
                'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-zinc-700': period ==
                    '3m',
                ' text-gray-600 dark:text-gray-300': period != '3m'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-zinc-600">
            {{ '3' . __('m') }}
        </div>
        <div @click="changePeriod('1y');"
            :class="{
                'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-zinc-700': period ==
                    '1y',
                ' text-gray-600 dark:text-gray-300': period != '1y'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-zinc-600">
            {{ '1' . __('y') }}
        </div>
        <div @click="changePeriod('all');"
            :class="{
                'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-zinc-700': period ==
                    'all',
                ' text-gray-600 dark:text-gray-300': period != 'all'
            }"
            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-zinc-600">
            {{ __('All') }}
        </div>
    </div>
</div>
