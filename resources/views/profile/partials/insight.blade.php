<section class="space-y-6">
    @php
        $channel = $user->channel;
    @endphp

    <header>
        <div class="flex justify-between mb-2">
            <h2 class="text-lg text-gray-950 dark:text-gray-50">
                {{ __('TM Insight channel') }}
            </h2>

            @if ($channel)
                <a href="{{ route('insight.channel.show', ['channel' => $user->channel->slug]) }}">
                    <x-secondary-button
                        class="bg-secondary-gradient dark:text-gray-800">{{ __('My channel') }}</x-secondary-button>
                </a>
            @endif
        </div>
    </header>

    @if ($channel)
        @include('insight.components.channel', [
            'id' => $channel->id,
            'name' => $channel->name,
            'slug' => $channel->slug,
            'logo' => $channel->logo,
            'description' => $channel->brief_description,
            'subscribers' => $channel->activeSubscribers()->count(),
        ])
    @endif

    <form method="POST" class="space-y-2 sm:space-y-4" enctype=multipart/form-data x-data="{ errors: [], loading: false }"
        action="{{ !$channel ? route('insight.channel.store') : route('insight.channel.update', ['channel' => $channel->slug]) }}"
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
        @if ($channel)
            @method('PUT')
        @endif

        <div class="sm:flex sm:space-x-3 space-y-2 sm:space-y-0">
            <div class="w-full">
                <x-input-label for="channel-name" :value="__('Channel name')" />
                <x-length-input id="channel-name" name="name" type="text" :value="$channel->name ?? old('name')" autocomplete="name"
                    required max="30" />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div class="w-full">
                <x-input-label for="channel-slug" :value="__('Channel address') . ' (a-z, 0-9, _)'" />
                <x-length-input id="channel-slug" name="slug" type="text" :value="$channel->slug ?? old('slug')" autocomplete="slug"
                    required max="20" regex="/[^a-z0-9_]/g" />
                <x-input-error :messages="$errors->get('slug')" />
            </div>
        </div>

        <div>
            <x-input-label for="channel-brief_description" :value="__('Brief description')" />
            <x-length-input id="channel-brief_description" name="brief_description" type="text" :value="$channel->brief_description ?? old('brief_description')"
                autocomplete="brief_description" required max="100" />
            <x-input-error :messages="$errors->get('brief_description')" />
        </div>

        <div>
            <x-input-label for="channel-description" :value="__('Channel description')" />
            <x-length-textarea id="channel-description" rows="4" name="description" required max="500"
                :value="$channel->description ?? (old('description') ?? '')" />
            <x-input-error :messages="$errors->get('description')" />
        </div>

        <div>
            <x-input-label for="channel-logo" :value="!$channel ? __('Logo') : __('Change logo')" />
            <x-file-input id="channel-logo" name="logo" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp"
                :required="!$channel" />
            <p class="mt-1 text-xxs text-gray-600" id="channel-logo_help">PNG, JPG
                or JPEG (max. 2MB)</p>
            <x-input-error :messages="$errors->get('logo')" />
        </div>

        <div>
            <x-input-label for="channel-banner" :value="!$channel || !$channel->banner ? __('Banner') : __('Change banner')" />
            <x-file-input id="channel-banner" name="banner" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp" />
            <p class="mt-1 text-xxs text-gray-600" id="channel-banner_help">PNG, JPG
                or JPEG (max. 5MB, 960x360 px)</p>
            <x-input-error :messages="$errors->get('banner')" />
        </div>

        <x-primary-button class="block ml-auto mt-4" ::disabled="loading"
            ::class="loading ? 'opacity-50 cursor-not-allowed' : ''">{{ __('Save') }}</x-primary-button>
    </form>
</section>
