<x-profile.section h="Difficulty changing"
    p="You can receive notifications about coin network difficulty, either periodically or instantly. You select the coins you want to monitor and set the notification parameters">
    @php
        $notification = \App\Models\User\NotificationType::where('name', 'Difficulty changing')->first();
        $settings = collect($user->settings->notifications);
        $coins = \App\Models\Database\Coin::whereHas('networkDifficulties')
            ->select(['id', 'name', 'abbreviation'])
            ->get();
    @endphp

    <form x-data="{ coins: {{ $coins->whereIn('id', $settings[$notification->id]['c'])->values() }} }" x-init="$watch('coins', coins => settings[{{ $notification->id }}]['c'] = coins.map(coin => coin.id))"
        @submit.prevent ="axios.patch('{{ route('profile.settings.update', ['setting' => 'notifications']) }}',
            {settings: settings}).then(r=> pushToastAlert(r.data.message, r.data.success ? 'success' : 'error'))">
        <div x-data="{ allCoins: {{ $coins->whereNotIn('id', $settings[$notification->id]['c'])->values() }}, search: '', get filteredCoins() { return this.allCoins.filter(allCoin => `${allCoin.abbreviation}`.toLowerCase().indexOf(this.search.toLowerCase()) !== -1 || `${allCoin.name}`.toLowerCase().indexOf(this.search.toLowerCase()) !== -1); } }">
            <div>
                <x-inputs.input-label for="search" :value="__('Coins')" />
                <div
                    class="mt-1 flex items-center overflow-hidden bg-white dark:bg-slate-950 rounded-md shadow-sm shadow-logo-color ring-1 ring-inset ring-slate-300 dark:ring-slate-700 focus-within:ring-indigo-500 dark:focus-within:ring-indigo-500 pr-2">
                    <input type="text" id="search" x-model="search" placeholder="Bitcoin"
                        class="py-1.5 px-3 bg-transparent border-0 focus:ring-0 text-slate-600 dark:text-slate-400 w-full" />
                </div>
            </div>

            <template x-if="coins.length">
                <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
                    <template x-for="coin in coins" :key="coin.id">
                        <div @click="coins.splice(coins.indexOf(coin), 1);allCoins.push(coin)"
                            x-text="coin.abbreviation"
                            class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-indigo-600 hover:bg-indigo-500 dark:hover:bg-slate-800 text-white text-xxs sm:text-xs">
                        </div>
                    </template>
                </div>
            </template>

            <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
                <template x-for="coin in filteredCoins.slice(0, 5)" :key="coin.id">
                    <div @click="coins.push(coin);allCoins.splice(allCoins.indexOf(coin), 1);search = ''"
                        x-text="coin.abbreviation"
                        class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-slate-50 dark:bg-slate-950 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-200 text-xxs sm:text-xs">
                    </div>
                </template>
                <div x-show="filteredCoins.length > 5"
                    class="px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-slate-50 dark:bg-slate-950 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-200 text-xxs sm:text-xs">
                    <span x-text="filteredCoins.length - 5"></span>
                    {{ __('coins more') }}
                </div>
            </div>
        </div>

        <div class="mt-4 {{ count($notification->settings) ? 'space-y-4' : 'space-y-2' }}">
            @foreach ($settings[$notification->id] as $directionName => $direction)
                @if ($directionName === 'c')
                    @continue
                @endif

                <div>
                    <x-inputs.checkbox :name="$notification->id . '_' . $directionName . '_on'" :checked="$direction['o']" value="1"
                        :handleChange="'(checked => settings[\'' . $notification->id . '\'][\'' . $directionName . '\'][\'o\'] = checked)'">
                        {{ __('settings.notifications.directions.' . $directionName) }}
                    </x-inputs.checkbox>

                    @foreach ($notification->settings as $setting => $variants)
                        <div class="mt-1 lg:mt-2">
                            <x-inputs.select ::disabled="!settings['{{ $notification->id }}']['{{ $directionName }}']['o']" :label="__('settings.notifications.settings.' . $setting . '.name')" :name="$notification->id . '_' . $directionName . '_' . $setting"
                                handleChange="(variant => settings['{{ $notification->id }}']['{{ $directionName }}']['{{ $setting }}'] = variant)"
                                :key="$settings[$notification->id][$directionName][$setting]" :items="collect($variants)
                                    ->map(
                                        fn($variant) => [
                                            'key' => $variant,
                                            'value' => __(
                                                'settings.notifications.settings.' . $setting . '.' . $variant,
                                            ),
                                        ],
                                    )
                                    ->keyBy('key')" />
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <template x-if="JSON.stringify(settings) != '{{ $settings }}'">
            <x-buttons.primary-button class="block ml-auto mt-4">{{ __('Save') }}</x-buttons.primary-button>
        </template>
    </form>
</x-profile.section>
