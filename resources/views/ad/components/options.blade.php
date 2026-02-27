<div x-data="{ open: false }">
    <button @click="open = ! open" aria-label="Options"
        class="ml-2 sm:ml-3 inline-flex items-center p-2 text-sm text-center text-gray-950 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 rounded-lg hover:bg-gray-100 focus:ring-inset focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:hover:bg-zinc-800 dark:focus:ring-zinc-700">
        <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 4 15">
            <path
                d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
        </svg>
    </button>

    <div x-show="open" @mouseleave="open = false" @click.away="open = false" style="display: none"
        class="z-100 -right-0.5 bottom-[44px] absolute bg-white divide-y divide-gray-100 rounded-lg shadow-lg shadow-logo-color border-2 border-gray-100 dark:border-zinc-700 min-w-32 w-full max-w-44 dark:bg-zinc-800 dark:divide-zinc-700">
        <ul class="py-2 text-xs sm:text-sm text-gray-800 dark:text-gray-100" aria-labelledby="ad-options-trigger">
            @if ($owner)
                <li>
                    <a href="{{ route('ad.edit', ['ad' => $ad->id]) }}"
                        class="block px-3 py-2 sm:px-4 hover:bg-gray-100 dark:hover:bg-zinc-700 dark:hover:text-white">{{ __('Edit') }}</a>
                </li>
                <li
                    class="flex px-3 py-2 sm:px-4 rounded hover:bg-gray-100 dark:hover:bg-zinc-700 dark:hover:text-white">
                    <x-toggler ::checked="hidden" x-on:toggle-checked="toggle">{{ __('Toggle hidden') }}</x-toggler>
                </li>
            @else
                @php
                    $trackClick =
                        $user && $user->tariff
                            ? 'axios.post("/ads/' .
                                $ad->ad_category_name .
                                '/' .
                                $ad->id .
                                '/track").then(r => {
                            pushToastAlert(r.data.message, r.data.success ? "success" : "error");

                            if (r.data.tracking) {
                                $el.closest(".offer-card").getElementsByClassName("tracking")[0].classList.remove("hidden");
                                $el.getElementsByTagName("span")[0].innerHTML = "' .
                                __('Untrack price') .
                                '";
                                ' .
                                ($user->tg_id === null
                                    ? 'if (!window.tgDontAsk) $dispatch("open-modal", "tg-auth");'
                                    : '') .
                                '
                            } else {
                                $el.closest(".offer-card").getElementsByClassName("tracking")[0].classList.add("hidden");
                                $el.getElementsByTagName("span")[0].innerHTML = "' .
                                __('To track') .
                                '";
                            }
                        })'
                            : '$dispatch("open-modal", "need-subscription")';
                @endphp

                <li @click="{{ $trackClick }}"
                    class="flex items-center cursor-pointer px-3 py-2 sm:px-4 hover:bg-gray-100 dark:hover:bg-zinc-700 dark:hover:text-white">
                    <svg class="w-4 h-4 mr-2 xs:mr-3" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                    </svg>
                    <span>{{ $user && $user->trackedAds->where('id', $ad->id)->count() ? __('Untrack price') : __('To track') }}</span>
                </li>
                <li>
                    <a class="flex items-center px-3 py-2 sm:px-4 hover:bg-gray-100 dark:hover:bg-zinc-700 dark:hover:text-white"
                        target="_blank" href="{{ route('chat.start', ['user' => $ad->user_id, 'ad_id' => $ad->id]) }}">
                        <svg class="w-4 h-4 mr-2 xs:mr-3" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M7 9h5m3 0h2M7 12h2m3 0h5M5 5h14a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-6.616a1 1 0 0 0-.67.257l-2.88 2.592A.5.5 0 0 1 8 18.477V17a1 1 0 0 0-1-1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                        </svg>
                        {{ __('Contact') }}
                    </a>
                </li>
                @if ($ad->user_has_phone)
                    <li class="flex items-center cursor-pointer px-3 py-2 sm:px-4 hover:bg-gray-100 dark:hover:bg-zinc-700 dark:hover:text-white"
                        x-data="{ number: '{{ __('View number') }}' }"
                        @click="if (/^\d+$/.test(number)) window.open('tel:+' + number);
                        else axios.get('{{ route('phone.show', ['user' => $ad->user_id, 'ad_id' => $ad->id]) }}')
                        .then(r => number = r.data.number);">
                        <svg class="w-4 h-4 mr-2 xs:mr-3" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z" />
                        </svg>
                        <span x-text="number"></span>
                    </li>
                @endif
            @endif
        </ul>
    </div>
</div>
