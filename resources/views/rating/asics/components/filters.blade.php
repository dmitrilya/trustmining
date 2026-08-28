<div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-lg shadow-logo-color rounded-xl p-2 sm:p-4 lg:p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="flex flex-col">
            <h3
                class="flex items-center gap-2 font-bold text-base sm:text-lg text-slate-800 dark:text-slate-200 mb-3 pb-2 border-b border-slate-300 dark:border-slate-700">
                <span>🪙</span>{{ __('By coin') }}
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($coins as $coin)
                    <a href="{{ route('rating.asics.show', ['type' => $type ?? 'profit', 'filter' => 'coin-' . strtolower($coin['n'])]) }}"
                        class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-500 text-xs text-slate-700 dark:text-slate-300 transition-colors">
                        <img src="{{ Storage::url('public/coins/' . $coin['a'] . '.webp') }}" alt="{{ $coin['n'] }} icon" class="w-4 h-4">
                        <span>{{ $coin['n'] }} ({{ $coin['a'] }})</span>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex flex-col">
            <h3
                class="flex items-center gap-2 font-bold text-base sm:text-lg text-slate-800 dark:text-slate-200 mb-3 pb-2 border-b border-slate-300 dark:border-slate-700">
                <span>⚙️</span>{{ __('By hashing algorithm') }}
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($algos as $algo)
                    <a href="{{ route('rating.asics.show', ['type' => $type ?? 'profit', 'filter' => 'algorithm-' . strtolower($algo)]) }}"
                        class="px-3 py-1.5 rounded-lg bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-500 text-xs text-slate-700 dark:text-slate-300 transition-colors">
                        <span>{{ $algo }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex flex-col">
            <h3
                class="flex items-center gap-2 font-bold text-base sm:text-lg text-slate-800 dark:text-slate-200 mb-3 pb-2 border-b border-slate-300 dark:border-slate-700">
                <span>❄️</span>{{ __('By cooling type') }}
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($coolings as $cooling)
                    <a href="{{ route('rating.asics.show', ['type' => $type ?? 'profit', 'filter' => 'cooling-' . $cooling['slug']]) }}"
                        class="px-3 py-1.5 rounded-lg bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-500 text-xs text-slate-700 dark:text-slate-300 transition-colors">
                        <span>{{ $cooling['n'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="flex flex-col">
            <h3
                class="flex items-center gap-2 font-bold text-base sm:text-lg text-slate-800 dark:text-slate-200 mb-3 pb-2 border-b border-slate-300 dark:border-slate-700">
                <span>💰</span>{{ __('By budget') }}
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($prices as $price)
                    <a href="{{ route('rating.asics.show', ['type' => $type ?? 'profit', 'filter' => 'price-' . $price['slug']]) }}"
                        class="px-3 py-1.5 rounded-lg bg-emerald-500/10 dark:bg-emerald-500/5 border border-emerald-500/30 dark:border-emerald-500/20 hover:border-emerald-500 text-xs font-medium text-emerald-700 dark:text-emerald-400 transition-colors">
                        <span>{{ $price['n'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex flex-col md:col-span-2 lg:col-span-1">
            <h3
                class="flex items-center gap-2 font-bold text-base sm:text-lg text-slate-800 dark:text-slate-200 mb-3 pb-2 border-b border-slate-300 dark:border-slate-700">
                <span>🚀</span>{{ __('By purpose and novelty') }}
            </h3>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('rating.asics.show', ['type' => $type ?? 'profit', 'filter' => 'home']) }}"
                    class="px-3 py-1.5 rounded-lg bg-orange-500/10 dark:bg-orange-500/5 border border-orange-500/30 dark:border-orange-500/20 hover:border-orange-500 text-xs font-medium text-orange-700 dark:text-orange-400 transition-colors">
                    🏠 {{ __('For home (Quiet)') }}
                </a>
                <a href="{{ route('rating.asics.show', ['type' => $type ?? 'profit', 'filter' => 'new']) }}"
                    class="px-3 py-1.5 rounded-lg bg-blue-500/10 dark:bg-blue-500/5 border border-blue-500/30 dark:border-blue-500/20 hover:border-blue-500 text-xs font-medium text-blue-700 dark:text-blue-400 transition-colors">
                    ✨ {{ __('New equipment') }}
                </a>
            </div>
        </div>
    </div>
</div>
