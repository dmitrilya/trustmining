<x-insight-layout title="Редактирование своего канала | TM Insight" noindex="true"
    description="Отредактируйте канал на платформе TM Insight и начните делиться контентом | TM Insight"
    :header="__('Channel edit')">
    <div
        class="p-2 sm:p-4 lg:p-6 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl">
        <form method="POST" class="flex flex-col gap-2 sm:gap-4 lg:gap-6" enctype=multipart/form-data
            x-data="{ validation: [], loading: false }" action="{{ route('insight.channel.update', ['channel' => $channel->slug]) }}"
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
            @method('PUT')

            <div class="sm:flex sm:space-x-3 space-y-2 sm:space-y-0">
                <div class="w-full">
                    <x-input-label for="channel-name" :value="__('Channel name')" />
                    <x-length-input id="channel-name" name="name" type="text" :value="$channel->name"
                        autocomplete="name" required max="30" />
                    <template x-if="validation.name">
                        <p class="text-red-500 text-xs mt-1" x-text="validation.name?.[0]"></p>
                    </template>
                </div>

                <div class="w-full">
                    <x-input-label for="channel-slug" :value="__('Channel address') . ' (a-z, 0-9, _)'" />
                    <x-length-input id="channel-slug" name="slug" type="text" :value="$channel->slug"
                        autocomplete="slug" required max="20" regex="/[^a-z0-9_]/g" />
                    <template x-if="validation.slug">
                        <p class="text-red-500 text-xs mt-1" x-text="validation.slug?.[0]"></p>
                    </template>
                </div>
            </div>

            <div>
                <x-input-label for="channel-brief_description" :value="__('Brief description')" />
                <x-length-input id="channel-brief_description" name="brief_description" type="text" :value="$channel->brief_description"
                    autocomplete="brief_description" required max="100" />
                <template x-if="validation.brief_description">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.brief_description?.[0]"></p>
                </template>
            </div>

            <div>
                <x-input-label for="channel-description" :value="__('Channel description')" />
                <x-length-textarea id="channel-description" rows="4" name="description" required max="500"
                    :value="$channel->description" />
                <template x-if="validation.description">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.description?.[0]"></p>
                </template>
            </div>

            <div>
                <x-input-label for="channel-logo" :value="__('Change logo')" />
                <x-file-input id="channel-logo" name="logo" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp"
                    required />
                <p class="mt-1 text-xxs text-slate-500" id="channel-logo_help">(max. 2MB)</p>
                <template x-if="validation.logo">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.logo?.[0]"></p>
                </template>
            </div>

            <div>
                <x-input-label for="channel-banner" :value="__('Change Banner')" />
                <x-file-input id="channel-banner" name="banner" class="mt-1 block w-full"
                    accept=".png,.jpg,.jpeg,.webp" />
                <p class="mt-1 text-xxs text-slate-500" id="channel-banner_help">(max. 5MB, 960x360 px)</p>
                <template x-if="validation.banner">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.banner?.[0]"></p>
                </template>
            </div>

            <x-primary-button class="block ml-auto" ::disabled="loading"
                ::class="loading ? 'opacity-50 cursor-progress' : ''">{{ __('Save') }}</x-primary-button>
        </form>
    </div>
</x-insight-layout>
