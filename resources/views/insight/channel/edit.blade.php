<x-insight-layout title="Редактирование своего канала | TM Insight" noindex="true"
    description="Отредактируйте канал на платформе TM Insight и начните делиться контентом | TM Insight"
    :header="__('Channel edit')">
    <div
        class="p-2 sm:p-4 lg:p-6 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow shadow-logo-color rounded-xl">
        <form method="POST" class="flex flex-col gap-2 sm:gap-4 lg:gap-6" enctype=multipart/form-data
            x-data="{ errors: [], loading: false }" action="{{ route('insight.channel.update', ['channel' => $channel->slug]) }}"
            @submit.prevent="
            if (Object.keys(errors).length > 0) {
                pushToastAlert(Object.values(errors)[0], 'error');
                $el.querySelector(`[name='${Object.keys(errors)[0]}']`).focus();
            } else {
                loading = true;
                axios.post('{{ route('insight.channel.check-slug') }}', { slug: $el.querySelector('[name=slug]').value })
                    .then(r => {
                        if (r.data.success) $el.submit();
                        else {
                            loading = false;
                            pushToastAlert(r.data.error, 'error');
                        }
                    });
            }">
            @csrf
            @method('PUT')

            <div class="sm:flex sm:space-x-3 space-y-2 sm:space-y-0">
                <div class="w-full">
                    <x-input-label for="channel-name" :value="__('Channel name')" />
                    <x-length-input id="channel-name" name="name" type="text" :value="$channel->name"
                        autocomplete="name" required max="30" />
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div class="w-full">
                    <x-input-label for="channel-slug" :value="__('Channel address') . ' (a-z, 0-9, _)'" />
                    <x-length-input id="channel-slug" name="slug" type="text" :value="$channel->slug"
                        autocomplete="slug" required max="20" regex="/[^a-z0-9_]/g" />
                    <x-input-error :messages="$errors->get('slug')" />
                </div>
            </div>

            <div>
                <x-input-label for="channel-brief_description" :value="__('Brief description')" />
                <x-length-input id="channel-brief_description" name="brief_description" type="text" :value="$channel->brief_description"
                    autocomplete="brief_description" required max="100" />
                <x-input-error :messages="$errors->get('brief_description')" />
            </div>

            <div>
                <x-input-label for="channel-description" :value="__('Channel description')" />
                <x-length-textarea id="channel-description" rows="4" name="description" required max="500"
                    :value="$channel->description" />
                <x-input-error :messages="$errors->get('description')" />
            </div>

            <div>
                <x-input-label for="channel-logo" :value="__('Change logo')" />
                <x-file-input id="channel-logo" name="logo" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp"
                    required />
                <p class="mt-1 text-xxs text-gray-600" id="channel-logo_help">PNG, JPG
                    or JPEG (max. 1MB)</p>
                <x-input-error :messages="$errors->get('logo')" />
            </div>

            <div>
                <x-input-label for="channel-banner" :value="__('Change Banner')" />
                <x-file-input id="channel-banner" name="banner" class="mt-1 block w-full"
                    accept=".png,.jpg,.jpeg,.webp" />
                <p class="mt-1 text-xxs text-gray-600" id="channel-banner_help">PNG, JPG
                    or JPEG (max. 2MB, 960x360 px)</p>
                <x-input-error :messages="$errors->get('banner')" />
            </div>

            <x-primary-button class="block ml-auto" ::disabled="loading"
                ::class="loading ? 'opacity-50 cursor-not-allowed' : ''">{{ __('Save') }}</x-primary-button>
        </form>
    </div>
</x-insight-layout>
