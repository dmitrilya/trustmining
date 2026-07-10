<div class="space-y-1 xs:space-y-2 sm:space-y-4">
    <a href="{{ route('metrics.network.difficulty', ['coin' => 'bitcoin']) }}"
        class="text-sm lg:text-base font-bold block w-max cursor-pointer {{ $attributes->get('active') == 'network_difficulty' ? 'text-slate-800 dark:text-slate-200' : 'under text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200' }}">{{ __('Network difficulty') }}</a>
    <a href="{{ route('metrics.network.hashrate', ['coin' => 'bitcoin']) }}"
        class="text-sm lg:text-base font-bold block w-max cursor-pointer {{ $attributes->get('active') == 'network_hashrate' ? 'text-slate-800 dark:text-slate-200' : 'under text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200' }}">{{ __('Network hashrate') }}</a>
    <a href="{{ route('metrics.coin.rate', ['coin' => 'bitcoin']) }}"
        class="text-sm lg:text-base font-bold block w-max cursor-pointer {{ $attributes->get('active') == 'coin_rate' ? 'text-slate-800 dark:text-slate-200' : 'under text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200' }}">{{ __('Coin rate') }}</a>
</div>
