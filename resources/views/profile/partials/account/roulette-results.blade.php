<section>
    <header class="mb-2">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-lg text-slate-800 dark:text-slate-200">
                {{ __('Roulette results') }}
            </h2>

            @if ($user->company && !$user->company->moderation)
                <a
                    href="{{ route('support', ['tab' => 'chat', 'message' => __('Hello! Our company is offering a roulette prize draw. We are giving away... conditions are...')]) }}">
                    <x-buttons.secondary-button
                        class="bg-secondary-gradient dark:text-slate-800">{{ __('Start draw') }}</x-buttons.secondary-button>
                </a>
            @endif
        </div>
    </header>

    @if (!$user->company || $user->company->moderation)
        <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">
            {{ __('You can also launch a roulette draw. To do this, you need to add a company, verify it, and submit a request to our support team.') }}
        </p>
    @endif

    <div class="space-y-2">
        @foreach ($user->ownPrizes()->with(['rouletteSpins.user'])->get() as $prize)
            @php
                $startDate = $prize->activated_at;
                $endDate = $prize->deactivated_at ?? now();

                $totalSiteSpinsInPeriod = \App\Models\Roulette\RouletteSpin::whereBetween('created_at', [
                    $startDate,
                    $endDate,
                ])->count();

                $allPrizeSpins = $prize->rouletteSpins;
                $authorizedSpins = $allPrizeSpins->whereNotNull('user_id');
                $withTgIdSpins = $authorizedSpins->filter(fn($spin) => $spin->user && !empty($spin->user->tg_id));
            @endphp

            <div class="pt-2 border-t border-slate-300 dark:border-slate-800">
                <div class="flex justify-between items-center mb-2">
                    <div class="text-slate-800 dark:text-slate-200 font-extrabold text-base tracking-tight">
                        {{ $prize->name }}
                    </div>

                    @if (!is_null($prize->deactivated_at))
                        <div
                            class="px-2.5 py-1 bg-rose-500/10 border border-rose-500/30 rounded-full text-xxs text-rose-500 font-black uppercase tracking-wider">
                            🔴 {{ __('Deactivated') }}
                        </div>
                    @elseif (is_null($prize->activated_at))
                        <div
                            class="px-2.5 py-1 bg-amber-500/10 border border-amber-500/30 rounded-full text-xxs text-amber-500 font-black uppercase tracking-wider">
                            ⏳ {{ __('Awaiting launch') }}
                        </div>
                    @else
                        <div
                            class="px-2.5 py-1 bg-emerald-500/10 border border-emerald-500/30 rounded-full text-xxs text-emerald-500 font-black uppercase tracking-wider">
                            🟢 {{ __('Launched') }}
                        </div>
                    @endif
                </div>

                <div class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    {{ $prize->caption }}
                </div>

                @if (!is_null($prize->activated_at))
                    <div class="text-xxs text-slate-500 mt-1">
                        Период розыгрыша:
                        {{ $startDate->format('d.m.Y H:i') }} —
                        {{ $prize->deactivated_at ? $prize->deactivated_at->format('d.m.Y H:i') : 'настоящее время' }}
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                        <div
                            class="flex flex-col justify-between bg-slate-50 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-800/80 p-3 rounded-xl text-center">
                            <span
                                class="block text-xxs font-bold text-slate-500 uppercase tracking-wider mb-1">1.
                                Спинов в период</span>
                            <span
                                class="text-lg font-black text-slate-600 dark:text-slate-400 font-mono">{{ $totalSiteSpinsInPeriod }}</span>
                        </div>

                        <div
                            class="flex flex-col justify-between bg-slate-50 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-800/80 p-3 rounded-xl text-center">
                            <span
                                class="block text-xxs font-bold text-slate-500 uppercase tracking-wider mb-1">2.
                                Выпадений приза</span>
                            <span class="text-lg font-black text-indigo-600 dark:text-indigo-400 font-mono">
                                {{ $allPrizeSpins->count() }}
                            </span>
                        </div>

                        <div
                            class="flex flex-col justify-between bg-slate-50 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-800/80 p-3 rounded-xl text-center">
                            <span
                                class="block text-xxs font-bold text-slate-500 uppercase tracking-wider mb-1">3.
                                Авторизовано</span>
                            <span class="text-lg font-black text-indigo-500 font-mono">
                                {{ $authorizedSpins->count() }}
                            </span>
                        </div>

                        <div
                            class="flex flex-col justify-between bg-slate-50 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-800/80 p-3 rounded-xl text-center">
                            <span
                                class="block text-xxs font-bold text-slate-500 uppercase tracking-wider mb-1">4.
                                С привязкой TG</span>
                            <span class="text-lg font-black text-emerald-500 font-mono">
                                {{ $withTgIdSpins->count() }}
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-end mt-2">
                        <button type="button"
                            data-url="{{ route('roulette.download-results', ['roulettePrize' => $prize->id]) }}"
                            class="download-tg-ids inline-flex items-center gap-2 px-3 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700/80 border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-400 font-bold text-xs uppercase tracking-wider rounded-lg transition-all shadow-sm cursor-pointer">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span>Скачать TG ID ({{ $withTgIdSpins->pluck('user.tg_id')->unique()->count() }})</span>
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</section>
