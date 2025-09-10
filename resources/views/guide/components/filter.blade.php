<div x-data="{ allTags: {{ $tags }}, tags: [], search: '' }">
    <div>
        <x-input-label for="search" :value="__('Hashtag')" />
        <x-text-input id="search" type="text" ::value="search" placeholder="#" @input="search = $el.value" />
    </div>

    <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
        <template x-for="tag in tags" :key="tag">
            <div @click="tags.splice(tags.indexOf(tag), 1);allTags.push(tag)" x-text="tag"
                class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-indigo-600 hover:bg-indigo-500 dark:hover:bg-gray-700 text-white text-xxs sm:text-xs">
            </div>
        </template>
    </div>

    <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
        <template x-for="tag in allTags.filter(allTag => `${allTag}`.indexOf(search) !== -1).slice(0, 10)" :key="tag">
            <div @click="tags.push(tag);allTags.splice(allTags.indexOf(tag), 1);" x-text="tag"
                class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 text-xxs sm:text-xs">
            </div>
        </template>
        <div x-show="allTags.filter(allTag => `${allTag}`.indexOf(search) !== -1).length > 10"
            class="px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 text-xxs sm:text-xs">
            <span x-text="allTags.filter(allTag => `${allTag}`.indexOf(search) !== -1).length - 10"></span>
            {{ __('tags more') }}
        </div>
    </div>

    <template x-for="tag in tags" :key="tag">
        <input type="hidden" name="tags[]" :value="tag">
    </template>
</div>
