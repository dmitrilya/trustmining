<section class="space-y-6">
    <header>
        <h2 class="font-extrabold text-lg text-slate-800 dark:text-slate-200">
            {{ __('Notification settings') }}
        </h2>

        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            {{ __('Customize your notifications.') }}
        </p>
    </header>

    @php
        $settings = collect($user->settings->notifications);
        $excludeTypes = ['Difficulty changing'];
    @endphp

    <form x-data="{ settings: {{ $settings }} }"
        @submit.prevent="axios.patch('{{ route('profile.settings.update', ['setting' => 'notifications']) }}', {settings: settings})
            .then(r => pushToastAlert(r.data.message, r.data.success ? 'success' : 'error'))">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            @foreach (\App\Models\User\NotificationType::whereIn('id', $settings->keys())->whereNotIn('name', $excludeTypes)->get() as $notification)
                <div class="border border-slate-300 dark:border-slate-700 shadow-md rounded-xl p-2 lg:p-4">
                    <h2 class="text-slate-800 dark:text-slate-200 mb-2 lg:mb-4">
                        {{ __($notification->name) }}
                    </h2>

                    <div class="{{ count($notification->settings) ? 'space-y-4' : 'space-y-2' }}">
                        @foreach ($settings[$notification->id] as $directionName => $direction)
                            <div>
                                <x-inputs.checkbox :name="$notification->id . '_' . $directionName . '_enabled'" :checked="$direction['enabled']" value="1"
                                    :handleChange="'(checked => settings[\'' . $notification->id . '\'][\'' . $directionName . '\'][\'enabled\'] = checked)'">
                                    {{ __('settings.notifications.directions.' . $directionName) }}
                                </x-inputs.checkbox>

                                @foreach ($notification->settings as $setting => $variants)
                                    <div class="mt-1 lg:mt-2">
                                        <x-inputs.select ::disabled="!settings['{{ $notification->id }}']['{{ $directionName }}']['enabled']" :label="__('settings.notifications.settings.' . $setting . '.name')" :name="$notification->id . '_' . $directionName . '_' . $setting"
                                            handleChange="(variant => settings['{{ $notification->id }}']['{{ $directionName }}']['{{ $setting }}'] = variant)"
                                            :key="$settings[$notification->id][$directionName][$setting]" :items="collect($variants)
                                                ->map(
                                                    fn($variant) => [
                                                        'key' => $variant,
                                                        'value' => __(
                                                            'settings.notifications.settings.' .
                                                                $setting .
                                                                '.' .
                                                                $variant,
                                                        ),
                                                    ],
                                                )
                                                ->keyBy('key')" />
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <template x-if="JSON.stringify(settings) != '{{ $settings }}'">
            <x-buttons.primary-button class="block ml-auto mt-4">{{ __('Save') }}</x-buttons.primary-button>
        </template>
    </form>
</section>
