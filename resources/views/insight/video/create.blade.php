<x-insight-layout title="Добавление видео | TM Insight" description="Добавьте видео на сайте TrustMining | TM Insight"
    :header="__('Creation video')">

    <div
        class="p-4 sm:p-8 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl">
        <form action="{{ route('insight.video.store', ['channel' => $channel->slug]) }}" method="POST"
            class="flex flex-col gap-4" enctype=multipart/form-data x-data="{ validation: [], loading: false }"
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

            <div class="w-full">
                <x-input-label for="video-title" :value="__('Title')" />
                <x-length-input id="video-title" name="title" type="text" :value="old('title')" autocomplete="title"
                    required max="100" />
                <template x-if="validation.title">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.title?.[0]"></p>
                </template>
            </div>

            <div>
                <x-input-label for="preview" :value="__('Preview')" />
                <x-file-input id="preview" name="preview" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp"
                    required />
                <p class="mt-1 text-sm text-slate-500" id="file_input_help">(max. 5MB), 4/3</p>
                <template x-if="validation.preview">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.preview?.[0]"></p>
                </template>
            </div>

            <div class="w-full">
                <x-input-label for="video-url" :value="__('Url')" />
                <x-text-input id="video-url" name="url" type="text" :value="old('url')" autocomplete="url"
                    required />
                <template x-if="validation.preview">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.url?.[0]"></p>
                </template>
            </div>

            <x-select :label="__('Series')" name="series_id" :items="collect([['key' => 0, 'value' => __('Without series')]])
                ->concat($channel->series->map(fn($series) => ['key' => $series->id, 'value' => $series->name]))
                ->keyBy('key')" />

            <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
        </form>
    </div>
</x-insight-layout>
