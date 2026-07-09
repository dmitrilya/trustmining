<x-profile.section h="Notification settings" p="Customize your notifications">
    @php
        $settings = collect($user->settings->notifications);
        $excludeTypes = ['Difficulty changing'];
        $hdcTg = '$dispatch(\'open-modal\', \'tg-auth\')';
        $notificationText = addslashes(
            __('Enable notifications in the site settings (lock icon near the address bar)'),
        );
        $hdcWeb = "if ('Notification' in window) {
            if (Notification.permission === 'denied')
                pushToastAlert('$notificationText', 'error');
            else Notification.requestPermission().then(p => webEnabled = (p === 'granted'));
        }";
    @endphp

    <form
        @submit.prevent="axios.patch('{{ route('profile.settings.update', ['setting' => 'notifications']) }}', {settings: settings})
            .then(r => pushToastAlert(r.data.message, r.data.success ? 'success' : 'error'))">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            @foreach (\App\Models\User\NotificationType::whereIn('id', $settings->keys())->whereNotIn('name', $excludeTypes)->get() as $notification)
                @php
                    $selectItems = [];
                    foreach ($notification->settings as $setting => $variants) {
                        $selectItems[$setting] = collect($variants)
                            ->map(
                                fn($variant) => [
                                    'key' => $variant,
                                    'value' => __('settings.notifications.settings.' . $setting . '.' . $variant),
                                ],
                            )
                            ->keyBy('key');
                    }
                @endphp

                <div class="border border-slate-300 dark:border-slate-700 shadow-md rounded-xl p-2 lg:p-4">
                    <h2 class="text-slate-800 dark:text-slate-200 mb-2 lg:mb-4">
                        {{ __($notification->name) }}
                    </h2>

                    <div class="{{ count($notification->settings) ? 'space-y-4' : 'space-y-2' }}">
                        @foreach ($settings[$notification->id] as $directionName => $direction)
                            @php
                                $name = $notification->id . '_' . $directionName . '_on';
                                $isTg = $directionName === 't';
                                $isWeb = $directionName === 'w';
                                $noTgId = !$user->tg_id || $user->tg_id === 0;
                                $serverDisabled = $isTg && $noTgId;
                                $serverChecked = $direction['o'] && !$serverDisabled && !$isWeb;

                                $disabledConditions = [
                                    't' => $noTgId ? 'true' : 'false',
                                    'w' => '!webEnabled',
                                ];
                                $disabledCondition = $disabledConditions[$directionName] ?? 'false';

                                $checkedConditions = [
                                    'w' => "settings['{$notification->id}']['w']['o'] && webEnabled",
                                    't' =>
                                        "settings['{$notification->id}']['t']['o'] && " . ($noTgId ? 'false' : 'true'),
                                ];
                                $checkedCondition =
                                    $checkedConditions[$directionName] ??
                                    "settings['{$notification->id}']['{$directionName}']['o']";

                                $hdc = $isTg ? $hdcTg : ($isWeb ? $hdcWeb : null);
                                $handleChange = "(checked => settings['$notification->id']['$directionName']['o'] = checked)";
                            @endphp

                            <div>
                                <x-inputs.checkbox value="1" :name="$name" :checked="$serverChecked" ::checked="{{ $checkedCondition }}"
                                    :disabled="$serverDisabled" ::disabled="{{ $disabledCondition }}" :handleChange="$handleChange" :handleDisabledClick="$hdc">
                                    {{ __('settings.notifications.directions.' . $directionName) }}
                                </x-inputs.checkbox>

                                @foreach ($notification->settings as $setting => $variants)
                                    <div class="mt-1 lg:mt-2">
                                        <x-inputs.select ::disabled="!settings['{{ $notification->id }}']['{{ $directionName }}']['o'] ||
                                            {{ $disabledCondition }}" :label="__('settings.notifications.settings.' . $setting . '.name')" :name="$notification->id . '_' . $directionName . '_' . $setting"
                                            handleChange="(variant => settings['{{ $notification->id }}']['{{ $directionName }}']['{{ $setting }}'] = variant)"
                                            :key="$settings[$notification->id][$directionName][$setting]" :items="collect($selectItems[$setting])" />
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
</x-profile.section>
