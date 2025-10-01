<div class="space-y-1 xs:space-y-2 sm:space-y-3 p-2 sm:p-3">
    <a href="{{ route('metrics.network.difficulty', ['coin' => 'bitcoin']) }}"
        class="text-xs sm:text-sm font-bold block w-max under cursor-pointer {{ $attributes->get('active') == 'network_difficulty' ? 'text-gray-700' : 'text-gray-500' }} hover:text-gray-700">{{ __('Network difficulty') }}</a>
    <a href="{{ route('metrics.network.hashrate', ['coin' => 'bitcoin']) }}"
        class="text-xs sm:text-sm font-bold block w-max under cursor-pointer {{ $attributes->get('active') == 'network_hashrate' ? 'text-gray-700' : 'text-gray-500' }} hover:text-gray-700">{{ __('Network hashrate') }}</a>
</div>
