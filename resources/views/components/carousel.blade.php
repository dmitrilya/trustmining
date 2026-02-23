@props(['images', 'max' => '96', 'min' => '56', 'model'])

<div id="ad-images" class="relative max-w-full rounded-lg overflow-hidden" x-data="{ slide: 1, slides: '{{ count($images) }}', width: 0 }" x-init="width = $el.clientWidth">
    <div class="max-h-[360px] duration-700 ease-in-out flex items-center relative h-full"
        :style="{ left: -1 * (slide - 1) * width + 'px' }">
        @foreach ($images as $image)
            <div class="rounded-lg overflow-hidden bg-white" x-init="$el.style.minWidth = width + 'px'">
                @if (isset($model))
                    @switch($model)
                        @case('office_card')
                            @php
                                $preview = explode('.', $image);
                                $baseName = preg_replace('/_[0-9]+$/', '', $preview[0]);
                                $previewxs = $baseName . '_212' . '.' . $preview[1];
                            @endphp

                            <picture class="w-full">
                                <source media="(max-width: 480px)" srcset="{{ Storage::url($previewxs) }}">

                                <img class="w-full object-cover" src="{{ Storage::url($image) }}" alt="Office preview">
                            </picture>
                        @break
                    @endswitch
                @else
                    <img src="{{ Storage::url($image) }}" class="w-full block" alt="...">
                @endif
            </div>
        @endforeach
    </div>

    @if (count($images) > 1)
        <div class="absolute z-30 flex -translate-x-1/2 bottom-3 sm:bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            @foreach ($images as $image)
                <button type="button" class="size-3 sm:size-4 border border-gray-300 dark:border-zinc-700 rounded-full"
                    @click="slide = {{ $loop->iteration }}"
                    :class="{
                        'bg-gray-300 dark:bg-zinc-600': slide == {{ $loop->iteration }},
                        'bg-gray-100 dark:bg-zinc-800 hover:bg-gray-200 dark:hover:bg-zinc-700': slide !=
                            {{ $loop->iteration }}
                    }"
                    aria-label="{{ 'Slide ' . $loop->iteration }}"></button>
            @endforeach
        </div>

        <button type="button" @click="if (slide > 1) slide--; else slide = {{ count($images) }}"
            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-2 sm:px-4 cursor-pointer group focus:outline-none">
            <span
                class="inline-flex items-center justify-center size-6 sm:size-10 rounded-full bg-gray-100 dark:bg-zinc-800 group-hover:bg-gray-200 dark:group-hover:bg-zinc-700 group-focus:ring-2 group-focus:ring-gray-50 dark:group-focus:ring-zinc-600 group-focus:outline-none">
                <svg class="size-2 sm:size-4 text-gray-500 rtl:rotate-180" aria-hidden="true" fill="none"
                    viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" @click="if (slide < slides) slide++; else slide = 1"
            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-2 sm:px-4 cursor-pointer group focus:outline-none">
            <span
                class="inline-flex items-center justify-center size-6 sm:size-10 rounded-full bg-gray-100 dark:bg-zinc-800 group-hover:bg-gray-200 dark:group-hover:bg-zinc-700 group-focus:ring-2 group-focus:ring-gray-50 dark:group-focus:ring-zinc-600 group-focus:outline-none">
                <svg class="size-2 sm:size-4 text-gray-500 rtl:rotate-180" aria-hidden="true" fill="none"
                    viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    @endif
</div>
