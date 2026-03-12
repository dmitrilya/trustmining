@if ($user && $ad->user->id == $user->id)
    @if (($lastM = $ad->moderations->reverse()->first()) && $lastM->moderation_status_id == 3)
        <div class="flex items-center mt-6">
            <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" aria-hidden="true" viewBox="0 0 20 20">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z" />
            </svg>
            <p class="text-sm text-slate-500">
                {{ __('The ad did not pass moderation for the following reason:') }}</p>
        </div>
        <p class="mt-2 text-xxs xs:text-xs sm:text-sm text-slate-900 dark:text-slate-200">
            {{ $lastM->comment }}</p>
    @endif

    <a class="block mt-6" href="{{ route('ad.edit', ['ad' => $ad->id]) }}">
        <x-primary-button>{{ __('Edit') }}</x-primary-button>
    </a>
@else
    @php
        $trackClick =
            $user && $user->tariff
                ? 'axios.post("/ads/' .
                    $ad->adCategory->name .
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
                    ($user->tg_id === null ? 'if (!window.tgDontAsk) $dispatch("open-modal", "tg-auth");' : '') .
                    '
                                                } else {
                                                    $el.closest(".offer-card").getElementsByClassName("tracking")[0].classList.add("hidden");
                                                    $el.getElementsByTagName("span")[0].innerHTML = "' .
                    __('Track price') .
                    '";
                                                }
                                            })'
                : '$dispatch("open-modal", "need-subscription")';
    @endphp

    <div class="flex flex-wrap gap-3 sm:gap-4 mt-6">
        <a class="block w-full sm:w-max" target="_blank"
            href="{{ route('chat.start', ['user' => $ad->user->id, 'ad_id' => $ad->id]) }}">
            <x-primary-button class="w-full flex items-center justify-center xs:py-3">
                <svg class="min-w-4 h-4 mr-1 xs:mr-2" aria-hidden="true" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M7 9h5m3 0h2M7 12h2m3 0h5M5 5h14a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-6.616a1 1 0 0 0-.67.257l-2.88 2.592A.5.5 0 0 1 8 18.477V17a1 1 0 0 0-1-1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                </svg>
                {{ __('Buy') }}
            </x-primary-button>
        </a>

        @if (count($ad->user->phones))
            <x-secondary-button class="w-full sm:w-max justify-center bg-secondary-gradient dark:text-slate-800 xs:py-3"
                x-data="{ number: null, status: '{{ __('View number') }}' }"
                @click="if (!number) axios.get('{{ route('phone.show', ['user' => $ad->user->id, 'ad_id' => $ad->id]) }}')
                                                .then(r => {
                                                    if (r.data.success) number = '+' + r.data.number;
                                                    else status = r.data.number;
                                                }); else window.open('tel:' + number);">
                <svg class="min-w-4 h-4 mr-1 xs:mr-2" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z" />
                </svg>
                <span x-text="number ? number : status"></span>
            </x-secondary-button>
        @endif

        <x-secondary-button class="w-full sm:w-max justify-center xs:py-3" @click="{{ $trackClick }}">
            <svg class="min-w-4 h-4 mr-1 xs:mr-2" aria-hidden="true" width="24" height="24" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
            </svg>
            <span>{{ $user && $user->trackedAds->where('id', $ad->id)->count() ? __('Untrack price') : __('Track price') }}</span>
        </x-secondary-button>
    </div>
@endif
