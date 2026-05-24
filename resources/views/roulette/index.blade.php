<x-app-layout title="Список всех розыгрышей" noindex="true">
    <div class="max-w-9xl mx-auto px-2 py-4 sm:p-6 md:p-8" x-data="{ selectedPrize: null }">
        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6 mb-6">
            <x-primary-button class="block ml-auto mb-4"
                x-on:click.prevent="$dispatch('open-modal', 'roulette-prize-create')">
                {{ __('Create') }}
            </x-primary-button>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 sm:gap-4">
                @foreach ($prizes as $prize)
                    <div class="border border-slate-300 dark:border-slate-700 p-2 sm:p-4 rounded-lg">
                        <div class="flex mb-3">
                            <div class="rounded-full overflow-hidden min-w-16 size-16 mr-2">
                                <img src="{{ Storage::url($prize->user->company->logo) }}" alt="">
                            </div>

                            <div>
                                <div class="text-slate-800 dark:text-slate-200 font-bold mb-1">
                                    {{ $prize->name }}
                                </div>

                                <div class="text-sm text-slate-600 dark:text-slate-400">
                                    {{ $prize->caption }}
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap justify-end gap-2">
                            @if (!$prize->deactivated_at)
                                @if ($prize->activated_at)
                                    <x-danger-button
                                        x-on:click.prevent="selectedPrize = {{ $prize }};$dispatch('open-modal', 'roulette-prize-toggle-active')">
                                        {{ __('Deactivate') }}
                                    </x-danger-button>
                                @else
                                    <x-primary-button
                                        x-on:click.prevent="selectedPrize = {{ $prize }};$dispatch('open-modal', 'roulette-prize-toggle-active')">
                                        {{ __('Activate') }}
                                    </x-primary-button>
                                @endif
                            @endif

                            @if ($prize->activated_at)
                                <button type="button"
                                    data-url="{{ route('roulette.download-results', ['roulettePrize' => $prize->id]) }}"
                                    class="download-tg-ids inline-flex items-center gap-2 px-3 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700/80 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs uppercase tracking-wider rounded-lg transition-all shadow-sm cursor-pointer">
                                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none"
                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    <span>{{ __('Download') }}</span>
                                </button>
                            @endif

                            <x-secondary-button
                                x-on:click.prevent="selectedPrize = {{ $prize }};$dispatch('open-modal', 'roulette-prize-edit')">
                                {{ __('Edit') }}
                            </x-secondary-button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @include('roulette.create')
        @include('roulette.edit')
        @include('roulette.toggle-active')
    </div>
</x-app-layout>
