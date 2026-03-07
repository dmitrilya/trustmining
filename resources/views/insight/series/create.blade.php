<x-modal name="series-creation" maxWidth="md">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg text-slate-800 dark:text-slate-200">
                {{ __('Create series') }}
            </h2>

            <button type="button" aria-label="{{ __('Close') }}"
                class="ml-4 flex size-6 items-center justify-center rounded-md bg-white dark:bg-slate-950 text-slate-500"
                @click="show = false">
                <span class="sr-only">Close</span>
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form method="post" action="{{ route('insight.series.store', ['channel' => $channel->slug]) }}"
            x-data="{ validation: [], loading: false }" class="flex flex-col gap-2 sm:gap-4"
            @submit.prevent="if (Object.keys(validation).length > 0) {
                pushToastAlert(Object.values(validation)[0], 'error');
                $el.querySelector(`[name='${Object.keys(validation)[0]}']`).focus();
            } else if (!loading) {
                loading = true;
                axios.post($el.action, new FormData($el), {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then(r => {
                    if (r.data.success) window.location.href = r.data.redirect;
                }).catch(err => {
                    loading = false;
                    if (err.response && err.response.status === 422) validation = err.response.data.errors;
                });
            }">
            @csrf

            <div class="w-full">
                <x-input-label for="series-name" :value="__('Series name')" />
                <x-length-input id="series-name" name="name" type="text" autocomplete="series-name" required
                    max="30" />
                <template x-if="validation.name">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.name?.[0]"></p>
                </template>
            </div>

            <div>
                <x-input-label for="series-description" :value="__('Series description')" />
                <x-length-textarea id="series-description" rows="4" name="description" required max="300"
                    :value="old('description')" />
                <template x-if="validation.description">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.description?.[0]"></p>
                </template>
            </div>

            <x-primary-button class="block ml-auto mt-6" ::disabled="loading"
                ::class="loading ? 'opacity-50 cursor-progress' : ''">{{ __('Create') }}</x-primary-button>
        </form>
    </div>
</x-modal>
