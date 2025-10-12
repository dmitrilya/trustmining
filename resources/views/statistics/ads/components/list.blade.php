<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-2 xs:p-4 md:p-6 mt-4 sm:mt-6">
    <div class="sticky top-16 bg-white dark:bg-gray-800">
        <div class="py-4 grid grid-cols-7 md:grid-cols-8 lg:grid-cols-9 xl:grid-cols-10 gap-1 xs:gap-2">
            <div class="flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900 col-start-2"
                @click="sort('city')">
                <span class="w-4/5 max-w-max truncate">{{ __('City') }}</span>
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 size-3 sm:size-4">
                    <path
                        d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                        fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900 col-span-2"
                @click="sort('model')">
                {{ __('Model') }}
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 size-3 sm:size-4">
                    <path
                        d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                        fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900"
                @click="sort('views_count')">
                <span class="w-4/5 max-w-max truncate">{{ __('Views') }}</span>
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 size-3 sm:size-4">
                    <path
                        d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                        fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900"
                @click="sort('visits_count')">
                <span class="w-4/5 max-w-max truncate">{{ __('Visits') }}</span>
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 size-3 sm:size-4">
                    <path
                        d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                        fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900"
                @click="sort('phone_views_count')">
                <span class="w-4/5 max-w-max truncate">{{ __('Phone') }}</span>
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 size-3 sm:size-4">
                    <path
                        d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                        fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="hidden md:flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900"
                @click="sort('tracks_count')">
                <span class="w-4/5 max-w-max truncate">{{ __('Tracks') }}</span>
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 size-3 sm:size-4">
                    <path
                        d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                        fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="hidden lg:flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900"
                @click="sort('chats_count')">
                <span class="w-4/5 max-w-max truncate">{{ __('Chats') }}</span>
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 size-3 sm:size-4">
                    <path
                        d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                        fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="hidden xl:flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900"
                @click="sort('cr')">
                <span class="w-4/5 max-w-max truncate">CR</span>
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 size-3 sm:size-4">
                    <path
                        d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                        fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="divide-y divide-gray-300">
        <template x-for="ad in ads" :key="ad.id">
            <div class="py-1 sm:py-2 grid grid-cols-7 md:grid-cols-8 lg:grid-cols-9 xl:grid-cols-10 gap-1 xs:gap-2 items-center">
                <div class="rounded-md sm:rounded-lg overflow-hidden w-3/4 mx-auto">
                    <div class="w-full aspect-[4/3] overflow-hidden rounded-lg flex justify-center items-center">
                        <img :src="'/storage/' + ad.preview" alt="">
                    </div>
                </div>
                <div class="text-gray-500 text-xxs sm:text-xs" x-text="ad.city"></div>
                <div class="text-gray-500 text-xxs sm:text-xs col-span-2" x-text="ad.model"></div>
                <div class="text-gray-500 text-xxs sm:text-xs" x-text="ad.views_count"></div>
                <div class="text-gray-500 text-xxs sm:text-xs" x-text="ad.visits_count"></div>
                <div class="text-gray-500 text-xxs sm:text-xs" x-text="ad.phone_views_count"></div>
                <div class="hidden md:block text-gray-500 text-xxs sm:text-xs" x-text="ad.tracks_count"></div>
                <div class="hidden lg:block text-gray-500 text-xxs sm:text-xs" x-text="ad.chats_count"></div>
                <div class="hidden xl:block text-gray-500 text-xxs sm:text-xs" x-text="ad.cr !== '-' ? ad.cr + '%' : ad.cr"></div>
            </div>
        </template>
    </div>
</div>
