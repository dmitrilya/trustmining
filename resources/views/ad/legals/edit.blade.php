<div class="space-y-6">
    <input type="hidden" name="props" x-ref="props_legals" value="{{ json_encode($ad->props) }}" />

    <div>
        <x-input-label for="area_of_activity" :value="__('Area of ​​activity')" />
        <x-text-input id="area_of_activity" name="area_of_activity" type="text" autocomplete="area_of_activity" :value="$ad->props['Area of ​​activity']" required
            @change="let props = JSON.parse($refs.props_legals.value);props['Area of ​​activity'] = $el.value;$refs.props_legals.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('area_of_activity')" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" rows="16" name="description"
            class="mt-1 px-3 py-2 resize-none w-full px-0 text-sm text-gray-900 dark:text-gray-300 bg-gray-100 dark:bg-zinc-950 rounded-md border-gray-300 dark:border-zinc-700 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 shadow-sm dark:shadow-zinc-800"
            required maxlength="{{ $descriptionMaxLength }}">{{ $ad->description }}</textarea>
        <x-input-error :messages="$errors->get('description')" />
    </div>
</div>
