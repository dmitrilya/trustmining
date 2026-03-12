<div x-show="edit">
    <form action="{{ route('insight.video.update', ['channel' => $video->channel->slug, 'video' => $video->id]) }}"
        method="POST" class="space-y-6" enctype=multipart/form-data x-data="{ validation: [], loading: false }"
        @submit.prevent="if (Object.keys(validation).length > 0) {
                pushToastAlert(Object.values(validation)[0], 'error');
                $el.querySelector(`[name='${Object.keys(validation)[0]}']`).focus();
            } else if (!loading) {
                loading = true;
                axios.post($el.action, new FormData($el), {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(r => {
                    if (r.data.success) window.location.href = r.data.redirect;
                    else pushToastAlert(r.data.message, 'error');
                }).catch(err => {
                    loading = false;
                    if (err.response && err.response.status === 422) validation = err.response.data.errors;
                });
            }">
        @csrf
        @method('PUT')

        <div class="w-full">
            <x-input-label for="video-title" :value="__('Title')" />
            <x-length-input id="video-title" name="title" type="text" :value="$video->title" autocomplete="title" required
                max="100" />
            <template x-if="validation.title">
                <p class="text-red-500 text-xs mt-1" x-text="validation.title?.[0]"></p>
            </template>
        </div>

        <div>
            <x-input-label for="preview" :value="__('Preview')" />
            <x-file-input id="preview" name="preview" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp" />
            <p class="mt-1 text-sm text-slate-500" id="file_input_help">(max. 5MB), 4/3</p>
            <template x-if="validation.preview">
                <p class="text-red-500 text-xs mt-1" x-text="validation.preview?.[0]"></p>
            </template>
        </div>

        <x-select :label="__('Series')" name="series_id" :items="collect([['key' => 0, 'value' => __('Without series')]])
            ->concat($channel->series->map(fn($series) => ['key' => $series->id, 'value' => $series->name]))
            ->keyBy('key')" :key="$video->series->first()?->id" />

        <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
    </form>
</div>
