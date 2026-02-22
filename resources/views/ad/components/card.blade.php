<div class="card relative sm:max-w-md p-2 h-full md:p-3 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-md shadow-logo-color overflow-hidden rounded-lg flex flex-col justify-between offer-card"
    x-data="{
        hidden: {{ $ad->hidden ? 'true' : 'false' }},
        toggle() {
            toggleHidden({{ $ad->id }}).then(r => this.hidden = r ? !this.hidden : this.hidden);
        }
    }">
    <div>
        @if ($owner)
            <div class="mt-2 absolute z-10 left-0 top-4">
                <div x-show="hidden" style="display: none"
                    class="w-max cursor-default items-center px-1 py-0.5 bg-gray-800 dark:bg-zinc-700 opacity-60 border border-red-500 rounded-e-md text-xxs text-white uppercase shadow-sm shadow-logo-color hover:bg-red-400 transition ease-in-out duration-150">
                    {{ __('Hidden') }}
                </div>

                @if ($ad->last_moderation_status == 1)
                    <div
                        class="mt-1.5 w-max cursor-default items-center px-1 py-0.5 bg-gray-800 dark:bg-zinc-700 opacity-60 border border-red-500 rounded-e-md text-xxs text-white uppercase shadow-sm shadow-logo-color hover:bg-red-400 transition ease-in-out duration-150">
                        {{ __('Is under moderation') }}
                    </div>
                @elseif ($ad->last_moderation_status == 3)
                    <div
                        class="mt-1.5 w-max cursor-default items-center px-1 py-0.5 bg-red-900 opacity-60 border border-red-500 rounded-e-md text-xxs text-white uppercase shadow-sm shadow-logo-color hover:bg-red-400 transition ease-in-out duration-150">
                        {{ __('Rejected') }}
                    </div>
                @endif
            </div>
        @endif

        <div class="w-full aspect-[4/3] overflow-hidden rounded-lg flex justify-center items-center">
            <a class="block w-full" href="{{ route('ads.show', ['adCategory' => $ad->ad_category_name, 'ad' => $ad->id]) }}">
                @php
                    $preview = explode('.', $ad->preview);
                    $baseName = preg_replace('/_[0-9]+$/', '', $preview[0]);
                    $previewxs = $baseName . '_188' . '.' . $preview[1];
                    $previewsm = $baseName . '_292' . '.' . $preview[1];
                @endphp

                <picture>
                    <source media="(max-width: 430px)" srcset="{{ Storage::url($previewxs) }}">

                    <img class="w-full object-cover" src="{{ Storage::url($previewsm) }}" alt="Ad preview">
                </picture>
            </a>
        </div>

        <div class="mt-2 md:mt-3 flex items-start justify-between">
            @if ($ad->ad_category_name == 'miners')
                <div class="text-xs xs:text-sm md:text-base text-gray-950 dark:text-gray-50 font-bold">
                    {{ $ad->asic_model_name . ' ' . $ad->asic_version_hashrate . $ad->asic_version_measurement }}
                </div>
            @elseif ($ad->ad_category_name == 'gpus')
                <div class="text-xs xs:text-sm md:text-base text-gray-950 dark:text-gray-50 font-bold">
                    {{ $ad->gpu_brand_name . ' ' . $ad->gpu_model_name }}
                </div>
            @endif

            <div class="bg-gray-100 rounded-full ml-3 p-1.5 tracking{{ $ad->is_tracked ? '' : ' hidden' }}">
                <svg class="w-4 h-4 text-indigo-600" aria-hidden="true" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                </svg>
            </div>
        </div>

        <a href="{{ route('company', ['user' => $ad->user_url_name]) }}"
            class="block hover:underline text-xs md:text-sm text-indigo-600 hover:text-indigo-500 mt-1">{{ $ad->user_name }}</a>

        <div class="flex items-center my-1 md:my-2">
            <div
                class="trust mr-1 sm:mr-2 size-3 md:size-4 rounded-full border border-gray-300 dark:border-zinc-700 {{ $ad->user_tf > config('trustfactor.yellow') ? ($ad->user_tf > config('trustfactor.green') ? 'bg-green-500' : 'bg-yellow-300') : 'bg-red-600' }}">
            </div>
            <p class="text-xxs sm:text-xs md:text-sm text-gray-500">Trust Factor</p>
        </div>

        @if ($ad->ad_category_name == 'gpus')
            <p class="text-xxs sm:text-xs md:text-sm text-gray-500 dark:text-gray-400">
                {{ __('Power (kW/h)') . ': ' }}
                <span class="text-gray-700 dark:text-gray-300">{{ __($ad->gpu_model_max_power) }}</span>
            </p>
        @endif

        @foreach (json_decode($ad->props) as $prop => $value)
            <p class="text-xxs sm:text-xs md:text-sm text-gray-500 dark:text-gray-400">
                {{ __($prop) . ': ' }}@if (!is_array($value))
                    <span class="text-gray-700 dark:text-gray-300">{{ __($value) }}</span>
                @else
                    <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
                        @foreach ($value as $item)
                            <div
                                class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-indigo-600 hover:bg-indigo-500 dark:hover:bg-zinc-800 text-white text-xxs sm:text-xs">
                                {{ $item }}
                            </div>
                        @endforeach
                    </div>
                @endif
            </p>
        @endforeach
    </div>

    <div class="mt-2 md:mt-3">
        @if ($ad->price != 0 && $ad->with_vat)
            <div class="text-gray-600 dark:text-gray-400 text-xxs sm:text-xs">{{ __('The price includes VAT') }}</div>
        @endif

        <div class="text-gray-800 dark:text-gray-200 text-sm sm:text-base md:text-lg lg:text-xl font-bold">
            @if ($ad->price != 0)
                {{ $ad->price }} <span class="text-xxs sm:text-xs">{{ $ad->coin }}</span>
            @else
                {{ __('Price on request') }}
            @endif
        </div>

        <a href="{{ route('company.office', ['user' => $ad->user_url_name, 'office' => $ad->office_id]) }}"
            target="_blank"
            class="block hover:underline text-xxs sm:text-xs text-indigo-600 hover:text-indigo-500 mt-1 sm:mt-2">{{ $ad->city }}</a>

        <div class="relative flex mt-2 items-center">
            <a class="block w-full"
                href="{{ route('ads.show', ['adCategory' => $ad->ad_category_name, 'ad' => $ad->id]) }}">
                <x-primary-button
                    class="w-full justify-center text-xxs xs:text-xs">{{ __('Details') }}</x-primary-button>
            </a>

            <div x-data="{ open: false }">
                <button @click="open = ! open"
                    class="ml-2 xs:ml-3 inline-flex items-center p-2 text-sm text-center text-gray-950 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 rounded-md hover:bg-gray-100 focus:ring-inset focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:hover:bg-zinc-800 dark:focus:ring-zinc-700">
                    <svg class="w-4 xs:w-5 h-4 xs:h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 4 15">
                        <path
                            d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>
                </button>

                <div x-show="open" @mouseleave="open = false" style="display: none"
                    class="z-100 -right-0.5 bottom-[44px] absolute bg-white divide-y divide-gray-100 rounded-lg shadow-lg shadow-logo-color border-2 border-gray-100 dark:border-zinc-700 min-w-32 w-full max-w-44 dark:bg-zinc-800 dark:divide-zinc-700">
                    <ul class="py-2 text-xs sm:text-sm text-gray-800 dark:text-gray-100"
                        aria-labelledby="ad-options-trigger">
                        @if ($owner)
                            <li>
                                <a href="{{ route('ad.edit', ['ad' => $ad->id]) }}"
                                    class="block px-3 py-2 sm:px-4 hover:bg-gray-100 dark:hover:bg-zinc-700 dark:hover:text-white">{{ __('Edit') }}</a>
                            </li>
                            <li
                                class="flex px-3 py-2 sm:px-4 rounded hover:bg-gray-100 dark:hover:bg-zinc-700 dark:hover:text-white">
                                <x-toggler ::checked="hidden"
                                    x-on:toggle-checked="toggle">{{ __('Toggle hidden') }}</x-toggler>
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
                                            __('Track price') .
                                            '";
                            }
                        })'
                                        : '$dispatch("open-modal", "need-subscription")';
                            @endphp

                            <li @click="{{ $trackClick }}"
                                class="flex items-center cursor-pointer px-3 py-2 sm:px-4 hover:bg-gray-100 dark:hover:bg-zinc-700 dark:hover:text-white">
                                <svg class="w-4 h-4 mr-2 xs:mr-3" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                                </svg>
                                <span>{{ $user && $user->trackedAds->where('id', $ad->id)->count() ? __('Untrack price') : __('Track price') }}</span>
                            </li>
                            <li>
                                <a class="flex items-center px-3 py-2 sm:px-4 hover:bg-gray-100 dark:hover:bg-zinc-700 dark:hover:text-white"
                                    target="_blank"
                                    href="{{ route('chat.start', ['user' => $ad->user_id, 'ad_id' => $ad->id]) }}">
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
        </div>
    </div>
</div>
