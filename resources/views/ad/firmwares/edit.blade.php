<div class="space-y-6">
    <input type="hidden" name="props" x-ref="props_firmwares" value="{{ json_encode($ad->props) }}">

    <div x-data="{ allModels: {{ App\Models\Database\AsicModel::pluck('name') }}, models: {{ $ad->props['For which models'] }}, search: '' }">
        <div>
            <x-input-label for="search" :value="__('For which models')" />
            <x-text-input id="search" type="text" ::value="search" placeholder="" @input="search = $el.value" />
        </div>

        <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
            <template x-for="model in models" :key="model">
                <div>
                    <div @click="
                        models.splice(models.indexOf(model), 1);
                        allModels.push(model);
                        let props = JSON.parse($refs.props_firmwares.value);
                        props['For which models'] = models;
                        $refs.props_firmwares.value = JSON.stringify(props);
                    "
                        x-text="model"
                        class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-indigo-600 hover:bg-indigo-500 dark:hover:bg-zinc-800 text-white text-xxs sm:text-xs">
                    </div>
                    <input type="hidden" name="models[]" :value="model">
                </div>
            </template>
        </div>

        <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
            <template
                x-for="model in allModels.filter(allModel => `${allModel.toLowerCase()}`.indexOf(search.toLowerCase()) !== -1).slice(0, 20)"
                :key="model">
                <div @click="
                        models.push(model);
                        allModels.splice(allModels.indexOf(model), 1);
                        let props = JSON.parse($refs.props_firmwares.value);
                        props['For which models'] = models;
                        $refs.props_firmwares.value = JSON.stringify(props);
                    "
                    x-text="model"
                    class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-gray-50 dark:bg-zinc-950 hover:bg-gray-100 dark:hover:bg-zinc-800 text-gray-800 dark:text-gray-100 text-xxs sm:text-xs">
                </div>
            </template>
            <div x-show="allModels.filter(allModel => `${allModel.toLowerCase()}`.indexOf(search.toLowerCase()) !== -1).length > 20"
                class="px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-gray-50 dark:bg-zinc-950 hover:bg-gray-100 dark:hover:bg-zinc-800 text-gray-800 dark:text-gray-100 text-xxs sm:text-xs">
                <span x-text="allModels.filter(allModel => `${allModel}`.indexOf(search) !== -1).length - 20"></span>
                {{ __('models more') }}
            </div>
        </div>
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" rows="16" name="description"
            class="mt-1 px-3 py-2 resize-none w-full px-0 text-sm text-gray-950 dark:text-gray-200 bg-gray-100 dark:bg-zinc-950 rounded-md border-gray-300 dark:border-zinc-700 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 shadow-sm shadow-logo-color"
            required maxlength="{{ $descriptionMaxLength }}">{{ $ad->description }}</textarea>
        <x-input-error :messages="$errors->get('description')" />
    </div>
</div>
