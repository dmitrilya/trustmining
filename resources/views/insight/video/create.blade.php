<x-insight-layout title="Добавление видео | TM Insight" description="Добавьте видео на сайте TrustMining | TM Insight"
    :header="__('Creation video')">

    <div
        class="p-4 sm:p-8 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow shadow-logo-color rounded-xl">
        <form action="{{ route('insight.video.store', ['channel' => $channel->slug]) }}" method="POST"
            class="flex flex-col gap-4" enctype=multipart/form-data x-data="{ errors: [] }"
            @submit.prevent="if (Object.keys(errors).length > 0) {
                    pushToastAlert(Object.values(errors)[0], 'error');
                    $el.querySelector(`[name='${Object.keys(errors)[0]}']`).focus();
                } else $el.submit();">
            @csrf

            <div class="w-full">
                <x-input-label for="video-title" :value="__('Title')" />
                <x-length-input id="video-title" name="title" type="text" :value="old('title')" autocomplete="title"
                    required max="100" />
                <x-input-error :messages="$errors->get('title')" />
            </div>

            <div>
                <x-input-label for="preview" :value="__('Preview')" />
                <x-file-input id="preview" name="preview" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp"
                    required />
                <p class="mt-1 text-sm text-gray-600" id="file_input_help">PNG, JPG
                    or JPEG (max. 5MB), dimensions:ratio=4/3</p>
                <x-input-error :messages="$errors->get('preview')" />
            </div>

            <div class="w-full">
                <x-input-label for="video-url" :value="__('Url')" />
                <x-text-input id="video-url" name="url" type="text" :value="old('url')" autocomplete="url"
                    required />
                <x-input-error :messages="$errors->get('url')" />
            </div>

            <x-select :label="__('Series')" name="series_id" :items="collect([['key' => 0, 'value' => __('Without series')]])
                ->concat($channel->series->map(fn($series) => ['key' => $series->id, 'value' => $series->name]))
                ->keyBy('key')" />

            <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
        </form>
    </div>
</x-insight-layout>
