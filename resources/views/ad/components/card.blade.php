<div class="relative sm:max-w-md p-2 h-full md:p-3 bg-white/60 dark:bg-zinc-900/60 shadow-md shadow-logo-color overflow-hidden rounded-lg flex flex-col justify-between offer-card"
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

                @if ($ad->moderations->where('moderation_status_id', 1)->count())
                    <div
                        class="mt-1.5 w-max cursor-default items-center px-1 py-0.5 bg-gray-800 dark:bg-zinc-700 opacity-60 border border-red-500 rounded-e-md text-xxs text-white uppercase shadow-sm shadow-logo-color hover:bg-red-400 transition ease-in-out duration-150">
                        {{ __('Is under moderation') }}
                    </div>
                @elseif (($lastM = $ad->moderations->reverse()->first()) && $lastM->moderation_status_id == 3)
                    <div
                        class="mt-1.5 w-max cursor-default items-center px-1 py-0.5 bg-red-900 opacity-60 border border-red-500 rounded-e-md text-xxs text-white uppercase shadow-sm shadow-logo-color hover:bg-red-400 transition ease-in-out duration-150">
                        {{ __('Rejected') }}
                    </div>
                @endif
            </div>
        @endif

        <div class="w-full aspect-[4/3] overflow-hidden rounded-lg flex justify-center items-center">
            <a class="block w-full"
                href="{{ route('ads.show', ['adCategory' => $ad->adCategory->name, 'ad' => $ad->id]) }}">
                <img class="w-full" src="{{ Storage::url($ad->preview) }}">
            </a>
        </div>

        <div class="mt-2 md:mt-3 flex items-start justify-between">
            @if ($ad->adCategory->name == 'miners')
                <div class="text-xs xs:text-sm md:text-base text-gray-950 dark:text-gray-50 font-bold">
                    {{ $ad->asicVersion->asicModel->name . ' ' . $ad->asicVersion->hashrate . $ad->asicVersion->measurement }}
                </div>
            @endif

            <div
                class="bg-gray-100 rounded-full ml-3 p-1.5 tracking{{ $user && $user->trackedAds->where('id', $ad->id)->count() ? '' : ' hidden' }}">
                <svg class="w-4 h-4 text-indigo-600" aria-hidden="true" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                </svg>
            </div>
        </div>

        <a href="{{ route('company', ['user' => $ad->user->url_name]) }}"
            class="block hover:underline text-xs md:text-sm text-indigo-600 hover:text-indigo-500 mt-1">{{ $ad->user->name }}</a>

        <div class="flex items-center my-1 md:my-2">
            <div
                class="trust mr-1 sm:mr-2 size-3 md:size-4 rounded-full border border-gray-300 dark:border-zinc-700 {{ $ad->user->tf > config('trustfactor.yellow') ? ($ad->user->tf > config('trustfactor.green') ? 'bg-green-500' : 'bg-yellow-300') : 'bg-red-600' }}">
            </div>
            <p class="text-xxs sm:text-xs md:text-sm text-gray-500">Trust Factor</p>
        </div>

        @foreach ($ad->props as $prop => $value)
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

        <div class="text-gray-950 dark:text-white text-sm sm:text-base md:text-lg lg:text-xl font-bold">
            @if ($ad->price != 0)
                {{ $ad->price }} <span class="text-xxs sm:text-xs">{{ $ad->coin->abbreviation }}</span>
            @else
                {{ __('Price on request') }}
            @endif
        </div>

        <a href="{{ route('company.office', ['user' => $ad->user->url_name, 'office' => $ad->office->id]) }}"
            target="_blank"
            class="block hover:underline text-xxs sm:text-xs text-indigo-600 hover:text-indigo-500 mt-1 sm:mt-2">{{ $ad->office->city }}</a>

        <div class="relative flex mt-2 items-center">
            <a class="block w-full"
                href="{{ route('ads.show', ['adCategory' => $ad->adCategory->name, 'ad' => $ad->id]) }}">
                <x-primary-button
                    class="w-full justify-center text-xxs xs:text-xs">{{ __('Details') }}</x-primary-button>
            </a>

            @include('ad.components.options', ['owner' => $owner])
        </div>
    </div>
</div>
