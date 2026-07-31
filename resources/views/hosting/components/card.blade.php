@props(['ad', 'auth', 'hidden'])

<div
    class="card sm:max-w-md h-full bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden rounded-xl flex flex-col">
    @if (count($hosting->images))
        <div class="w-full aspect-[4/3] overflow-hidden rounded-xl justify-center items-center">
            <a class="block w-full" href="{{ route('company.hosting', ['user' => $hosting->user->slug]) }}"
                draggable="false" x-data="{ shown: false }" x-intersect.once.margin.300px="shown = true"
                aria-label="{{ $hosting->user->name }} hosting">
                @php
                    $preview = explode('.', $hosting->images[0]);
                    $baseName = preg_replace('/_[0-9]+$/', '', $preview[0]);
                    $previewxs = $baseName . '_224' . '.' . $preview[1];
                    $previewsm = $baseName . '_400' . '.' . $preview[1];
                @endphp

                <template x-if="shown">
                    <picture class="w-full">
                        <source media="(max-width: 430px)" srcset="{{ Storage::url($previewxs) }}">

                        <img class="w-full object-cover" src="{{ Storage::url($previewsm) }}" alt="Hosting preview">
                    </picture>
                </template>
            </a>
        </div>
    @endif

    <div class="flex flex-col flex-grow justify-between p-2 sm:p-3">
        <div>
            <a href="{{ route('company', ['user' => $hosting->user->slug]) }}" draggable="false"
                class="block hover:underline text-xs sm:text-sm text-indigo-500 hover:text-indigo-600">{{ $hosting->user->name }}</a>

            <x-tf :tf="$hosting->user->tf" class="my-1 md:my-2" />

            <x-peculiarities :ps="$hosting->peculiarities" model="hosting"></x-peculiarities>
        </div>

        <div class="mt-2 sm:mt-3">
            <div class="text-slate-800 dark:text-slate-200 text-sm sm:text-lg font-bold">{{ $hosting->price }} ₽</div>

            <div class="relative flex mt-2 items-center">
                <a class="block w-full" draggable="false"
                    href="{{ route('company.hosting', ['user' => $hosting->user->slug]) }}">
                    <x-buttons.secondary-button class="w-full justify-center">{{ __('Details') }}</x-buttons.secondary-button>
                </a>
            </div>
        </div>
    </div>
</div>
