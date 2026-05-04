@php
    $requestModels = request()['For_which_models'];
    $allModels = App\Models\Database\AsicModel::select(['id', 'name', 'slug'])->get();
@endphp

<div x-data="{ allModels: {{ $allModels->whereNotIn('slug', $requestModels)->values() }}, models: {{ $allModels->whereIn('slug', $requestModels) }}, search: '' }">
    <div>
        <x-input-label for="search" :value="__('For which models')" />
        <x-text-input id="search" type="text" ::value="search" placeholder="" @input="search = $el.value" />
    </div>

    <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
        <template x-for="model in models" :key="model.id">
            <div>
                <div @click="
                        models.splice(models.indexOf(model), 1);
                        allModels.push(model);
                    "
                    x-text="model.name"
                    class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-indigo-600 hover:bg-indigo-500 dark:hover:bg-slate-800 text-white text-xxs sm:text-xs">
                </div>
                <input type="hidden" name="For_which_models[]" :value="model.slug">
            </div>
        </template>
    </div>

    <div class="flex flex-wrap gap-0.5 sm:gap-1 my-2">
        <template
            x-for="model in allModels.filter(allModel => `${allModel.name.toLowerCase()}`.indexOf(search.toLowerCase()) !== -1).slice(0, 20)"
            :key="model.id">
            <div @click="
                        models.push(model);
                        allModels.splice(allModels.indexOf(model), 1);
                    "
                x-text="model.name"
                class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-slate-50 dark:bg-slate-950 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-100 text-xxs sm:text-xs">
            </div>
        </template>
        <div x-show="allModels.filter(allModel => `${allModel.name.toLowerCase()}`.indexOf(search.toLowerCase()) !== -1).length > 20"
            class="px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-slate-50 dark:bg-slate-950 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-100 text-xxs sm:text-xs">
            <span x-text="allModels.filter(allModel => `${allModel}`.indexOf(search) !== -1).length - 20"></span>
            {{ __('models more') }}
        </div>
    </div>
</div>
