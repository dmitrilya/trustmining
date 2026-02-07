<div class="space-y-6">
    <input type="hidden" name="props" x-ref="props_monitorings" value="{{ json_encode($ad->props) }}">

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" rows="16" name="description"
            class="mt-1 px-3 py-2 resize-none w-full px-0 text-sm text-gray-950 dark:text-gray-200 bg-gray-100 dark:bg-zinc-950 rounded-md border-gray-300 dark:border-zinc-700 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 shadow-sm shadow-logo-color"
            required maxlength="{{ $descriptionMaxLength }}">{{ $ad->description }}</textarea>
        <x-input-error :messages="$errors->get('description')" />
    </div>
</div>
