<div :class="{ '-left-full': !show, 'left-2 sm:left-4': show }"
    class="absolute top-16 sm:top-22 duration-300 lg:top-0 bg-slate-100 lg:left-0 lg:relative lg:col-span-3 xl:col-span-2 lg:bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-xl p-3 sm:p-4 lg:p-6">
    <div class="space-y-1 xs:space-y-2 sm:space-y-4">
        <a href="{{ route('metrics.network.difficulty', ['coin' => 'bitcoin']) }}"
            class="text-sm lg:text-base font-bold block w-max cursor-pointer {{ $attributes->get('active') == 'network_difficulty' ? 'text-slate-800 dark:text-slate-200' : 'under text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200' }}">{{ __('Network difficulty') }}</a>
        <a href="{{ route('metrics.network.hashrate', ['coin' => 'bitcoin']) }}"
            class="text-sm lg:text-base font-bold block w-max cursor-pointer {{ $attributes->get('active') == 'network_hashrate' ? 'text-slate-800 dark:text-slate-200' : 'under text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200' }}">{{ __('Network hashrate') }}</a>
        <a href="{{ route('metrics.coin.rate', ['coin' => 'bitcoin']) }}"
            class="text-sm lg:text-base font-bold block w-max cursor-pointer {{ $attributes->get('active') == 'coin_rate' ? 'text-slate-800 dark:text-slate-200' : 'under text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200' }}">{{ __('Coin rate') }}</a>
    </div>
</div>
