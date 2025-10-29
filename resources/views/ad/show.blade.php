<x-app-layout :description="$ad->adCategory->description" :title="$ad->adCategory->name == 'miners'
    ? 'Купить ASIC майнер ' .
        $ad->asicVersion->asicModel->asicBrand->name .
        ' ' .
        $ad->asicVersion->asicModel->name .
        ' ' .
        $ad->asicVersion->hashrate .
        $ad->asicVersion->measurement .
        ', ' .
        $ad->user->name
    : $ad->adCategory->title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            #{{ $ad->id }}
        </h2>
    </x-slot>

    @php
        $user = Auth::user();
    @endphp

    <div class="max-w-7xl mx-auto px-2 sm:px-6 md:px-8 py-8">
        @if (isset($moderation) && $user && in_array($user->role->name, ['admin', 'moderator']))
            @include('moderation.components.buttons', ['withUniqueCheck' => true])

            <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4 md:p-6 mb-6">
                <div class="mx-auto md:grid md:grid-cols-12 md:grid-rows-[auto,auto,1fr] md:gap-x-8 md:px-8 md:py-8">
                    <div
                        class="md:col-span-5{{ isset($moderation->data['preview']) || isset($moderation->data['images']) ? ' border border-indigo-500' : '' }}">
                        @php
                            $i = isset($moderation->data['images']) ? $moderation->data['images'] : $ad->images;
                            $p = isset($moderation->data['preview']) ? $moderation->data['preview'] : $ad->preview;
                        @endphp

                        @if (!count($i))
                            <div class="w-full overflow-hidden rounded-lg col-start-2">
                                <img src="{{ Storage::url($p) }}" class="w-full object-cover object-center">
                            </div>
                        @else
                            <x-carousel :images="array_merge([$p], $i)"></x-carousel>
                        @endif
                    </div>

                    <div class="mt-4 sm:mt-8 md:mt-0 md:col-span-7 md:border-l md:border-gray-200 md:pl-8">
                        @if ($ad->adCategory->name == 'miners')
                            <h1 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl md:text-3xl">
                                {{ $ad->asicVersion->asicModel->name . ' ' . $ad->asicVersion->hashrate . $ad->asicVersion->measurement }}
                            </h1>
                        @endif

                        <p
                            class="mt-5 text-2xl font-semibold text-gray-900{{ isset($moderation->data['price']) ? ' border border-indigo-500' : '' }}">
                            {{ isset($moderation->data['price']) ? $moderation->data['price'] : $ad->price }}
                            {{ $ad->coin->abbreviation }}</p>

                        <a href="{{ route('company.office', ['user' => $ad->user->url_name, 'office' => isset($moderation->data['office_id']) ? $moderation->data['office_id'] : $ad->office->id]) }}"
                            target="_blank"
                            class="flex items-center hover:underline text-sm sm:text-base text-indigo-600 hover:text-indigo-500 mt-2 sm:mt-3 md:mt-4{{ isset($moderation->data['office_id']) ? ' border border-indigo-500' : '' }}">
                            <svg class="w-5 h-5 mr-2" aria-hidden="true" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ isset($moderation->data['office_id']) ? App\Models\Office::find($moderation->data['office_id'])->address : $ad->office->address }}
                        </a>

                        <div class="md:col-span-2 md:col-start-1">
                            <div class="my-5">
                                <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                                    @foreach ($moderation->data['props'] as $prop => $value)
                                        <li class="text-xxs sm:text-xs md:text-sm text-gray-400 dark:text-gray-500">
                                            {{ __($prop) . ': ' }}<span
                                                class="text-gray-600 dark:text-gray-400">{{ __($value) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div>
                                @include('components.about-seller', ['user' => $ad->user, 'auth' => $user])
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 md:col-span-12">
                        <div>
                            <h3 class="font-bold tracking-tight text-gray-900">{{ __('Description') }}</h3>

                            <div class="space-y-6 mt-5">
                                <p
                                    class="text-sm sm:text-base text-gray-900{{ isset($moderation->data['description']) ? ' border border-indigo-500' : '' }}">
                                    {{ !isset($moderation->data['description']) ? (!$ad->description ? ($ad->adCategory->name == 'miners' ? $ad->asicVersion->asicModel->description : '') : $ad->description) : $moderation->data['description'] }}
                                </p>
                            </div>

                            @if ($ad->adCategory->name == 'miners')
                                <a class="block mt-6"
                                    href="{{ route('database.model', [
                                        'asicBrand' => strtolower(str_replace(' ', '_', $ad->asicVersion->asicModel->asicBrand->name)),
                                        'asicModel' => strtolower(str_replace(' ', '_', $ad->asicVersion->asicModel->name)),
                                    ]) }}">
                                    <x-secondary-button>{{ __('Model details about miner') }}</x-secondary-button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4 md:p-6">
            <div
                class="mx-auto md:grid md:grid-cols-12 md:grid-rows-[auto,auto,1fr] md:gap-x-8 md:px-8 md:py-8 ad-card">
                <div class="md:col-span-5">
                    @if (!count($ad->images))
                        <div class="w-full overflow-hidden rounded-lg col-start-2">
                            <img src="{{ Storage::url($ad->preview) }}" class="w-full object-cover object-center">
                        </div>
                    @else
                        <x-carousel :images="array_merge([$ad->preview], $ad->images)"></x-carousel>
                    @endif
                </div>

                <div class="mt-4 sm:mt-8 md:mt-0 md:col-span-7 md:border-l md:border-gray-200 md:pl-8">
                    <div class="flex items-start justify-between">
                        @if ($ad->adCategory->name == 'miners')
                            <h1 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl md:text-3xl">
                                {{ $ad->asicVersion->asicModel->name . ' ' . $ad->asicVersion->hashrate . $ad->asicVersion->measurement }}
                            </h1>
                        @endif

                        <div
                            class="bg-gray-100 rounded-full ml-3 p-1.5 sm:p-2 lg:p-2.5 tracking{{ $user && $user->trackedAds->where('id', $ad->id)->count() ? '' : ' hidden' }}">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-indigo-600" aria-hidden="true"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                            </svg>
                        </div>
                    </div>

                    <p class="mt-5 text-2xl font-semibold text-gray-900">{{ $ad->price }}
                        {{ $ad->coin->abbreviation }}</p>

                    <a href="{{ route('company.office', ['user' => $ad->user->url_name, 'office' => $ad->office->id]) }}"
                        target="_blank"
                        class="flex items-center hover:underline text-sm sm:text-base text-indigo-600 hover:text-indigo-500 mt-2 sm:mt-3 md:mt-4">
                        <svg class="w-5 h-5 mr-2" aria-hidden="true" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $ad->office->address }}
                    </a>

                    <div class="md:col-span-2 md:col-start-1">
                        <div class="my-5">
                            <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                                @foreach ($ad->props as $prop => $value)
                                    <li class="text-xxs sm:text-xs md:text-sm text-gray-400 dark:text-gray-500">
                                        {{ __($prop) . ': ' }}<span
                                            class="text-gray-600 dark:text-gray-400">{{ __($value) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div>
                            @include('components.about-seller', ['user' => $ad->user])

                            @if ($user && $ad->user->id == $user->id)
                                @if (($lastM = $ad->moderations->reverse()->first()) && $lastM->moderation_status_id == 3)
                                    <div class="flex items-center mt-6">
                                        <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" aria-hidden="true"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z" />
                                        </svg>
                                        <p class="text-sm text-gray-400">
                                            {{ __('The ad did not pass moderation for the following reason:') }}</p>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-800">{{ $lastM->comment }}</p>
                                @endif

                                <a class="block mt-6" href="{{ route('ad.edit', ['ad' => $ad->id]) }}">
                                    <x-primary-button>{{ __('Edit') }}</x-primary-button>
                                </a>
                            @else
                                @php
                                    $trackClick =
                                        $user && $user->tariff
                                            ? 'axios.post("/ads/' . $ad->adCategory->name . '/' .
                                                $ad->id .
                                                '/track").then(r => {
                                                pushToastAlert(r.data.message, r.data.success ? "success" : "error");

                                                if (r.data.tracking) {
                                                    $el.closest(".ad-card").getElementsByClassName("tracking")[0].classList.remove("hidden");
                                                    $el.getElementsByTagName("span")[0].innerHTML = "' .
                                                __('Untrack price') .
                                                '";
                                                    ' .
                                                ($user->tg_id === null
                                                    ? 'if (!window.tgDontAsk) $dispatch("open-modal", "tg-auth");'
                                                    : '') .
                                                '
                                                } else {
                                                    $el.closest(".ad-card").getElementsByClassName("tracking")[0].classList.add("hidden");
                                                    $el.getElementsByTagName("span")[0].innerHTML = "' .
                                                __('Track price') .
                                                '";
                                                }
                                            })'
                                            : '$dispatch("open-modal", "need-subscription")';
                                @endphp

                                <div class="flex flex-wrap gap-3 sm:gap-4 mt-6">
                                    <a class="block w-full sm:w-max"
                                        href="{{ route('chat.start', ['user' => $ad->user->id, 'ad_id' => $ad->id]) }}">
                                        <x-primary-button class="w-full flex items-center justify-center xs:py-3">
                                            <svg class="min-w-4 h-4 mr-1 xs:mr-2" aria-hidden="true" width="24"
                                                height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5"
                                                    d="M7 9h5m3 0h2M7 12h2m3 0h5M5 5h14a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-6.616a1 1 0 0 0-.67.257l-2.88 2.592A.5.5 0 0 1 8 18.477V17a1 1 0 0 0-1-1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                                            </svg>
                                            {{ __('Contact') }}
                                        </x-primary-button>
                                    </a>

                                    @if (count($ad->user->phones))
                                        <x-secondary-button
                                            class="w-full sm:w-max justify-center bg-secondary-gradient !text-white xs:py-3"
                                            x-data="{ number: null, status: '{{ __('View number') }}' }"
                                            @click="if (!number) axios.get('{{ route('phone.show', ['phone' => $ad->user->phones[0]->id, 'ad_id' => $ad->id]) }}')
                                                .then(r => {
                                                    if (r.data.success) number = '+' + r.data.number;
                                                    else status = r.data.number;
                                                }); else window.open('tel:' + number);">
                                            <svg class="min-w-4 h-4 mr-1 xs:mr-2" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z" />
                                            </svg>
                                            <span x-text="number ? number : status"></span>
                                        </x-secondary-button>
                                    @endif

                                    <x-secondary-button class="w-full sm:w-max justify-center xs:py-3"
                                        @click="{{ $trackClick }}">
                                        <svg class="min-w-4 h-4 mr-1 xs:mr-2" aria-hidden="true" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                                        </svg>
                                        <span>{{ $user && $user->trackedAds->where('id', $ad->id)->count() ? __('Untrack price') : __('Track price') }}</span>
                                    </x-secondary-button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-8 md:col-span-12">
                    <div>
                        @if ($ad->description || ($ad->adcategory->name == 'miners' && $ad->asicVersion->asicModel->description))
                            <h3 class="font-bold tracking-tight text-gray-900">{{ __('Description') }}</h3>

                            <div class="space-y-6 mt-5">
                                <p class="text-sm sm:text-base text-gray-900">
                                    {{ $ad->description ? $ad->description : $ad->asicVersion->asicModel->description }}
                                </p>
                            </div>
                        @endif

                        @if ($ad->adCategory->name == 'miners')
                            <a class="block mt-6"
                                href="{{ route('database.model', [
                                    'asicBrand' => strtolower(str_replace(' ', '_', $ad->asicVersion->asicModel->asicBrand->name)),
                                    'asicModel' => strtolower(str_replace(' ', '_', $ad->asicVersion->asicModel->name)),
                                ]) }}">
                                <x-secondary-button>{{ __('Model details about miner') }}</x-secondary-button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
