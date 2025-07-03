@props(['owner'])

<button id="ad-options-trigger" data-dropdown-toggle="{{ 'ad-options_' . $ad->id }}"
    class="ml-2 xs:ml-3 inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-md hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
    type="button">
    <svg class="w-4 xs:w-5 h-4 xs:h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 4 15">
        <path
            d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
    </svg>
</button>

<div id="{{ 'ad-options_' . $ad->id }}"
    class="z-100 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg border-2 border-gray-100 dark:border-gray-600 w-44 dark:bg-gray-700 dark:divide-gray-600">
    <ul class="py-2 text-xs sm:text-sm text-gray-700 dark:text-gray-200" aria-labelledby="ad-options-trigger">
        @if ($owner)
            <li>
                <a href="{{ route('ad.edit', ['ad' => $ad->id]) }}"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('Edit') }}</a>
            </li>
            <li class="flex px-4 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                <x-toggler ::checked="hidden" x-on:toggle-checked="toggle">{{ __('Toggle hidden') }}</x-toggler>
            </li>
        @else
            @php
                $trackClick = $user && $user->tariff ?
                    'axios.post("/ads/' .
                        $ad->id .
                        '/track").then(r => {
                            pushToastAlert(r.data.message, r.data.success ? "success" : "error");

                            if (r.data.tracking) {
                                $el.closest(".ad-card").getElementsByClassName("tracking")[0].classList.remove("hidden");
                                $el.getElementsByTagName("span")[0].innerHTML = "' . __('Untrack price') . '";
                                ' . ($user->tg_id === null ? 'if (!window.tgDontAsk) $dispatch("open-modal", "tg-auth");' : '') . '
                            } else {
                                $el.closest(".ad-card").getElementsByClassName("tracking")[0].classList.add("hidden");
                                $el.getElementsByTagName("span")[0].innerHTML = "' . __('Track price') . '";
                            }
                        })' :
                    '$dispatch("open-modal", "need-subscription")';
            @endphp
            
            <li @click="{{ $trackClick }}"
                class="flex items-center cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-4 h-4 mr-3" aria-hidden="true" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                </svg>
                <span>{{ $user && $user->trackedAds->where('id', $ad->id)->count() ? __('Untrack price') : __('Track price') }}</span>
            </li>
            <li>
                <a class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                    href="{{ route('chat.start', ['user' => $ad->user->id, 'ad' => $ad->id]) }}">
                    <svg class="w-4 h-4 mr-3" aria-hidden="true" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M7 9h5m3 0h2M7 12h2m3 0h5M5 5h14a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-6.616a1 1 0 0 0-.67.257l-2.88 2.592A.5.5 0 0 1 8 18.477V17a1 1 0 0 0-1-1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                    </svg>
                    {{ __('Contact') }}
                </a>
            </li>
        @endif
    </ul>
</div>
