<div
    class="card sm:max-w-md h-full bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 overflow-hidden rounded-xl flex flex-col">
    @if (count($gpu->images))
        <div class="w-full aspect-[4/3] overflow-hidden rounded-xl justify-center items-center">
            <a class="block w-full"
                href="{{ route('ads', ['adCategory' => 'gpus', 'model' => strtolower(str_replace(' ', '_', $gpu->name))]) }}">
                @php
                    $preview = explode('.', $gpu->images[0]);
                    $previewxs = $preview[0] . '_224' . '.' . $preview[1];
                    $previewsm = $preview[0] . '_320' . '.' . $preview[1];
                @endphp

                <picture class="w-full">
                    <source media="(max-width: 430px)" srcset="{{ Storage::url($previewxs) }}">

                    <img class="w-full object-cover" src="{{ Storage::url($previewsm) }}" alt="Gas genset preview">
                </picture>
            </a>
        </div>
    @endif

    <div class="flex flex-col flex-grow justify-between p-2 sm:p-3">
        <div>
            <div class="text-xs sm:text-sm md:text-base text-gray-950 dark:text-gray-50 font-bold">
                {{ $gpu->gpuBrand->name . ' ' . $gpu->name }}
            </div>

            <p class="mt-1 xs:mt-2 text-xxs sm:text-xs md:text-sm text-gray-500 dark:text-gray-400">
                {{ __('Power (kW/h)') . ': ' }}
                <span class="text-gray-700 dark:text-gray-300">{{ __($gpu->max_power) }}</span>
            </p>
        </div>

        <div class="mt-2 sm:mt-3">
            <div class="relative flex mt-2 items-center">
                <a class="block w-full"
                    href="{{ route('ads', ['adCategory' => 'gpus', 'model' => strtolower(str_replace(' ', '_', $gpu->name))]) }}">
                    <x-primary-button class="w-full justify-center">{{ __('Buy') }}</x-primary-button>
                </a>
            </div>
        </div>
    </div>
</div>
