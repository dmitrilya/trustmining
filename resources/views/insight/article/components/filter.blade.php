<div x-data="{ allTags: {{ $tags }}, tags: [], search: '' }">
    <div>
        <x-input-label for="search" :value="__('Hashtag')" />
        <x-text-input id="search" type="text" ::value="search" placeholder="#" @input="search = $el.value" />
    </div>

    <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
        <template x-for="tag in tags" :key="tag">
            <div @click="tags.splice(tags.indexOf(tag), 1);allTags.push(tag)" x-text="tag"
                class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-indigo-600 hover:bg-indigo-500 dark:hover:bg-slate-800 text-white text-xxs sm:text-xs">
            </div>
        </template>
    </div>

    <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
        <template x-for="tag in allTags.filter(allTag => `${allTag}`.toLowerCase().indexOf(search.toLowerCase()) !== -1).slice(0, 15)" :key="tag">
            <div @click="tags.push(tag);allTags.splice(allTags.indexOf(tag), 1);" x-text="tag"
                class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-slate-50 dark:bg-slate-950 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-100 text-xxs sm:text-xs">
            </div>
        </template>
        <div x-show="allTags.filter(allTag => `${allTag}`.toLowerCase().indexOf(search.toLowerCase()) !== -1).length > 15"
            class="px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-slate-50 dark:bg-slate-950 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-100 text-xxs sm:text-xs">
            <span x-text="allTags.filter(allTag => `${allTag}`.toLowerCase().indexOf(search.toLowerCase()) !== -1).length - 15"></span>
            {{ __('tags more') }}
        </div>
    </div>

    <template x-for="tag in tags" :key="tag">
        <input type="hidden" name="tags[]" :value="tag">
    </template>
</div>
