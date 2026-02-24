<div x-show="edit">
    <form action="{{ route('insight.video.update', ['channel' => $video->channel->slug, 'video' => $video->id]) }}"
        method="POST" class="space-y-6" enctype=multipart/form-data x-data="{ errors: [] }"
        @submit.prevent="if (Object.keys(errors).length > 0) {
            pushToastAlert(Object.values(errors)[0], 'error');
            $el.querySelector(`[name='${Object.keys(errors)[0]}']`).focus();
        } else $el.submit();">
        @csrf
        @method('PUT')

        <div class="w-full">
            <x-input-label for="video-title" :value="__('Title')" />
            <x-length-input id="video-title" name="title" type="text" :value="$video->title" autocomplete="title" required
                max="70" />
            <x-input-error :messages="$errors->get('title')" />
        </div>

        <div>
            <x-input-label for="preview" :value="__('Preview')" />
            <x-file-input id="preview" name="preview" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp" />
            <p class="mt-1 text-sm text-gray-600" id="file_input_help">PNG, JPG
                or JPEG (max. 2MB), dimensions:ratio=4/3</p>
            <x-input-error :messages="$errors->get('preview')" />
        </div>

        <x-select :label="__('Series')" name="series_id" :items="collect([['key' => 0, 'value' => __('Without series')]])
            ->concat($channel->series->map(fn($series) => ['key' => $series->id, 'value' => $series->name]))
            ->keyBy('key')" :key="$video->series->first()?->id" />

        <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
    </form>
</div>
