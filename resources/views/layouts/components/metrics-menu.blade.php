<div class="space-y-1 xs:space-y-2 sm:space-y-3">
    <a href="{{ route('metrics.network.difficulty', ['coin' => 'bitcoin']) }}"
        class="text-sm font-bold block w-max under cursor-pointer {{ $attributes->get('active') == 'network_difficulty' ? 'text-slate-700 dark:text-slate-200' : 'text-slate-500' }} hover:text-slate-700 dark:hover:text-slate-300">{{ __('Network difficulty') }}</a>
    <a href="{{ route('metrics.network.hashrate', ['coin' => 'bitcoin']) }}"
        class="text-sm font-bold block w-max under cursor-pointer {{ $attributes->get('active') == 'network_hashrate' ? 'text-slate-700 dark:text-slate-200' : 'text-slate-500' }} hover:text-slate-700 dark:hover:text-slate-300">{{ __('Network hashrate') }}</a>
</div>
