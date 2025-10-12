<div
    class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-2 xs:p-4 md:p-6 mt-4 sm:mt-6 overflow-hidden graph-container">
    <div
        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 xs:gap-4 sm:gap-5 mb-6 sm:mb-8 lg:mb-10">
        <label class="flex cursor-pointer" for="metric_views" @click="changeMetric('views')">
            <input type="radio" :checked="metric == 'views'"
                class="mr-2 size-3 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">

            <div>
                <div class="text-xxs sm:text-xs text-gray-400 dark:text-gray-600 mb-1 lg:mb-2">
                    {{ __('Views') }}</div>
                <div class="flex items-end">
                    <div class="text-sm leading-[16px] xs:text-base xs:leading-[18px] md:text-lg md:leading-[18px] xl:text-xl xl:leading-[22px] text-gray-800 dark:text-gray-200 mr-1 sm:mr-2 lg:mr-3"
                        x-text="all_views_count"></div>
                    <div class="text-xxs lg:text-xs"
                        :class="{
                            'text-green-500': views_count_coef > 0 || views_count_coef === '∞',
                            'text-red-500': views_count_coef < 0,
                            'text-gray-500': views_count_coef == 0
                        }"
                        x-text="views_count_coef != 0 ? views_count_coef > 0 || views_count_coef === '∞' ? '▲ ' + views_count_coef + '%' : '▼ ' + views_count_coef + '%' : '⬥ ' + views_count_coef + '%'">
                    </div>
                </div>
            </div>
        </label>

        <label class="flex cursor-pointer" for="metric_visits" @click="changeMetric('visits')">
            <input type="radio" :checked="metric == 'visits'"
                class="mr-2 size-3 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">

            <div>
                <div class="text-xxs sm:text-xs text-gray-400 dark:text-gray-600 mb-1 lg:mb-2">
                    {{ __('Visits') }}</div>
                <div class="flex items-end">
                    <div class="text-sm leading-[16px] xs:text-base xs:leading-[18px] md:text-lg md:leading-[18px] xl:text-xl xl:leading-[22px] text-gray-800 dark:text-gray-200 mr-1 sm:mr-2 lg:mr-3"
                        x-text="all_visits_count"></div>
                    <div class="text-xxs lg:text-xs"
                        :class="{
                            'text-green-500': visits_count_coef > 0 || visits_count_coef === '∞',
                            'text-red-500': visits_count_coef < 0,
                            'text-gray-500': visits_count_coef == 0
                        }"
                        x-text="visits_count_coef != 0 ? visits_count_coef > 0 || visits_count_coef === '∞' ? '▲ ' + visits_count_coef + '%' : '▼ ' + visits_count_coef + '%' : '⬥ ' + visits_count_coef + '%'">
                    </div>
                </div>
            </div>
        </label>

        <label class="flex cursor-pointer" for="metric_phone_views" @click="changeMetric('phone_views')">
            <input type="radio" :checked="metric == 'phone_views'"
                class="mr-2 size-3 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">

            <div>
                <div class="text-xxs sm:text-xs text-gray-400 dark:text-gray-600 mb-1 lg:mb-2">
                    {{ __('Phone views') }}</div>
                <div class="flex items-end">
                    <div class="text-sm leading-[16px] xs:text-base xs:leading-[18px] md:text-lg md:leading-[18px] xl:text-xl xl:leading-[22px] text-gray-800 dark:text-gray-200 mr-1 sm:mr-2 lg:mr-3"
                        x-text="all_phone_views_count"></div>
                    <div class="text-xxs lg:text-xs"
                        :class="{
                            'text-green-500': phone_views_count_coef > 0 || phone_views_count_coef === '∞',
                            'text-red-500': phone_views_count_coef < 0,
                            'text-gray-500': phone_views_count_coef == 0
                        }"
                        x-text="phone_views_count_coef != 0 ? phone_views_count_coef > 0 || phone_views_count_coef === '∞' ? '▲ ' + phone_views_count_coef + '%' : '▼ ' + phone_views_count_coef + '%' : '⬥ ' + phone_views_count_coef + '%'">
                    </div>
                </div>
            </div>
        </label>

        <label class="flex cursor-pointer" for="metric_tracks" @click="changeMetric('tracks')">
            <input type="radio" :checked="metric == 'tracks'"
                class="mr-2 size-3 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">

            <div>
                <div class="text-xxs sm:text-xs text-gray-400 dark:text-gray-600 mb-1 lg:mb-2">
                    {{ __('Tracks') }}</div>
                <div class="flex items-end">
                    <div class="text-sm leading-[16px] xs:text-base xs:leading-[18px] md:text-lg md:leading-[18px] xl:text-xl xl:leading-[22px] text-gray-800 dark:text-gray-200 mr-1 sm:mr-2 lg:mr-3"
                        x-text="all_tracks_count"></div>
                    <div class="text-xxs lg:text-xs"
                        :class="{
                            'text-green-500': tracks_count_coef > 0 || tracks_count_coef === '∞',
                            'text-red-500': tracks_count_coef < 0,
                            'text-gray-500': tracks_count_coef == 0
                        }"
                        x-text="tracks_count_coef != 0 ? tracks_count_coef > 0 || tracks_count_coef === '∞' ? '▲ ' + tracks_count_coef + '%' : '▼ ' + tracks_count_coef + '%' : '⬥ ' + tracks_count_coef + '%'">
                    </div>
                </div>
            </div>
        </label>

        <label class="flex cursor-pointer" for="metric_chats" @click="changeMetric('chats')">
            <input type="radio" :checked="metric == 'chats'"
                class="mr-2 size-3 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">

            <div>
                <div class="text-xxs sm:text-xs text-gray-400 dark:text-gray-600 mb-1 lg:mb-2">
                    {{ __('Chats') }}</div>
                <div class="flex items-end">
                    <div class="text-sm leading-[16px] xs:text-base xs:leading-[18px] md:text-lg md:leading-[18px] xl:text-xl xl:leading-[22px] text-gray-800 dark:text-gray-200 mr-1 sm:mr-2 lg:mr-3"
                        x-text="all_chats_count"></div>
                    <div class="text-xxs lg:text-xs"
                        :class="{
                            'text-green-500': chats_count_coef > 0 || chats_count_coef === '∞',
                            'text-red-500': chats_count_coef < 0,
                            'text-gray-500': chats_count_coef == 0
                        }"
                        x-text="chats_count_coef != 0 ? chats_count_coef > 0 || chats_count_coef === '∞' ? '▲ ' + chats_count_coef + '%' : '▼ ' + chats_count_coef + '%' : '⬥ ' + chats_count_coef + '%'">
                    </div>
                </div>
            </div>
        </label>

        <div>
            <div class="text-xxs sm:text-xs text-gray-400 dark:text-gray-600 mb-1 lg:mb-2">CR</div>
            <div class="flex items-end">
                <div class="text-sm leading-[16px] xs:text-base xs:leading-[18px] md:text-lg md:leading-[18px] xl:text-xl xl:leading-[22px] text-gray-800 dark:text-gray-200 mr-1 sm:mr-2 lg:mr-3"
                    x-text="all_cr">
                </div>
                <div class="text-xxs lg:text-xs"
                    :class="{
                        'text-green-500': cr_coef > 0 || cr_coef === '∞',
                        'text-red-500': cr_coef < 0,
                        'text-gray-500': cr_coef == 0
                    }"
                    x-text="cr_coef != 0 ? cr_coef > 0 || cr_coef === '∞' ? '▲ ' + cr_coef + '%' : '▼ ' + cr_coef + '%' : '⬥ ' + cr_coef + '%'">
                </div>
            </div>
        </div>
    </div>

    <div id="summary" class="h-[25rem] sm:h-[35rem]"></div>
</div>
