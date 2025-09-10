@props(['images', 'max' => '96', 'min' => '56'])

<div id="ad-images" class="relative w-full h-full" data-carousel="static">
    <div class="relative h-full min-h-{{ $min }} max-h-{{ $max }} overflow-hidden">
        @foreach ($images as $image)
            <div class="hidden duration-700 ease-in-out bg-white" data-carousel-item>
                <img src="{{ Storage::url($image) }}"
                    class="h-full rounded-lg absolute block -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                    alt="...">
            </div>
        @endforeach
    </div>

    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
        @foreach ($images as $image)
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true"
                aria-label="{{ 'Slide ' . $loop->iteration }}" data-carousel-slide-to="{{ $loop->index }}"></button>
        @endforeach
    </div>

    <button type="button"
        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-3 sm:px-4 cursor-pointer group focus:outline-none"
        data-carousel-prev>
        <span
            class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-100 group-hover:bg-gray-200 group-focus:ring-2 group-focus:ring-gray-50 group-focus:outline-none">
            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 1 1 5l4 4" />
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button"
        class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-3 sm:px-4 cursor-pointer group focus:outline-none"
        data-carousel-next>
        <span
            class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-100 group-hover:bg-gray-200 group-focus:ring-2 group-focus:ring-gray-50 group-focus:outline-none">
            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4" />
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>
