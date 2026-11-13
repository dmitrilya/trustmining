<div class="relative z-0 w-full group">
    <input type="text" id="gpu_model" disabled value="{{ $ad->gpuModel->name }}"
        class="block py-2.5 px-0 w-full text-sm text-slate-800 bg-transparent border-0 border-b-2 border-slate-300 appearance-none dark:text-slate-200 dark:border-slate-700 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
    <label for="gpu_model"
        class="absolute text-sm text-slate-600 dark:text-slate-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-left peer-focus:inset-s-0 peer-focus:text-indigo-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
        {{ __('Model') }}
    </label>
</div>

<input type="hidden" name="props" x-ref="props_gpus" value="{{ json_encode($ad->props) }}">

<div x-data="{ inStock: {{ $ad->props['Availability'] == 'In stock' ? 'true' : 'false' }} }">
    <x-inputs.toggler ::checked="inStock" :disabled="true" :big="true">{{ __('In stock') }}</x-inputs.toggler>

    <div x-show="!inStock" class="mt-4">
        <x-inputs.input-label for="waiting" :value="__('Waiting (days)')" />
        <x-inputs.text-input id="waiting" name="waiting" type="number" min="1" max="180" autocomplete="waiting"
            :value="isset($ad->props['Waiting (days)']) ? $ad->props['Waiting (days)'] : null"
            @change="let props = JSON.parse($refs.props_gpus.value);props['Waiting (days)'] = $el.value;$refs.props_gpus.value = JSON.stringify(props);" />
        <x-inputs.input-error :messages="$errors->get('waiting')" />
    </div>
</div>

<div x-data="{ anew: {{ $ad->props['Condition'] == 'New' ? 'true' : 'false' }} }">
    <x-inputs.toggler ::checked="anew" :disabled="true" :big="true">{{ __('New') }}</x-inputs.toggler>

    <div x-show="!anew">
        <div class="mt-4">
            <x-inputs.input-label for="warranty" :value="__('Warranty (months)')" />
            <x-inputs.text-input id="warranty" name="warranty" type="number" min="0" max="12"
                autocomplete="warranty" :value="isset($ad->props['Warranty (months)']) ? $ad->props['Warranty (months)'] : null"
                @change="let props = JSON.parse($refs.props_gpus.value);props['Warranty (months)'] = $el.value;$refs.props_gpus.value = JSON.stringify(props);" />
            <x-inputs.input-error :messages="$errors->get('warranty')" />
        </div>

        <div class="mt-6">
            <x-inputs.input-label for="images" :value="__('Change photo')" />
            <x-inputs.file-input id="images" name="images[]" class="mt-1 block w-full" multiple
                accept=".png,.jpg,.jpeg,.webp" max="3" label="max. 2MB, 3 items" />
            <x-inputs.input-error :messages="$errors->get('images')" />
            @foreach ($errors->get('images.*') as $error)
                <x-inputs.input-error :messages="$error" />
            @endforeach
        </div>
    </div>
</div>
