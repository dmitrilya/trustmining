@props(['ad', 'auth', 'hidden'])

<div
    class="card sm:max-w-md h-full bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 overflow-hidden rounded-xl flex flex-col">
    @if (count($hosting->images))
        <div class="w-full aspect-[4/3] overflow-hidden rounded-xl justify-center items-center">
            <a class="block w-full" href="{{ route('company.hosting', ['user' => $hosting->user->url_name]) }}">
                @php
                    $preview = explode('.', $hosting->images[0]);
                    $baseName = preg_replace('/_[0-9]+$/', '', $preview[0]);
                    $previewxs = $baseName . '_224' . '.' . $preview[1];
                    $previewsm = $baseName . '_400' . '.' . $preview[1];
                @endphp

                <picture class="w-full">
                    <source media="(max-width: 430px)" srcset="{{ Storage::url($previewxs) }}">

                    <img class="w-full object-cover" src="{{ Storage::url($previewsm) }}" alt="Hosting preview">
                </picture>
            </a>
        </div>
    @endif

    <div class="flex flex-col flex-grow justify-between p-2 sm:p-3">
        <div>
            <a href="{{ route('company', ['user' => $hosting->user->url_name]) }}"
                class="block hover:underline text-xs sm:text-sm text-indigo-600 hover:text-indigo-500">{{ $hosting->user->name }}</a>

            <div class="flex items-center my-1 md:my-2">
                <div
                    class="trust mr-1 sm:mr-2 size-3 md:size-4 rounded-full border border-gray-300 dark:border-zinc-700 {{ $hosting->user->tf > config('trustfactor.yellow') ? ($hosting->user->tf > config('trustfactor.green') ? 'bg-green-500' : 'bg-yellow-300') : 'bg-red-600' }}">
                </div>
                <p class="text-xxs sm:text-xs md:text-sm text-gray-500">Trust Factor</p>
            </div>

            <x-peculiarities :ps="$hosting->peculiarities" model="hosting"></x-peculiarities>
        </div>

        <div class="mt-2 sm:mt-3">
            <div class="text-gray-800 dark:text-gray-200 text-sm sm:text-lg font-bold">{{ $hosting->price }} ₽</div>

            <div class="relative flex mt-2 items-center">
                <a class="block w-full" href="{{ route('company.hosting', ['user' => $hosting->user->url_name]) }}">
                    <x-primary-button class="w-full justify-center">{{ __('Details') }}</x-primary-button>
                </a>
            </div>
        </div>
    </div>
</div>
