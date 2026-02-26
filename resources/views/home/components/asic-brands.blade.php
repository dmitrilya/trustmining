<div x-data="{ show: false }"
    class="transition-all px-1 py-3 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow shadow-logo-color rounded-xl">
    <h2 class="pt-1 px-3 mb-4 lg:mb-6 text-base text-gray-700 dark:text-gray-300 font-bold">
        {{ __('Brands') }}
    </h2>

    <div class="grid grid-cols-2 grid-cols-3 md:grid-cols-4 lg:grid-cols-2 gap-1">
        @foreach ($asicBrands->slice(0, 6) as $asicBrand)
            <a href="{{ route('database.brand', ['asicBrand' => strtolower(str_replace(' ', '_', $asicBrand->name))]) }}"
                class="h-9 flex items-center px-2 py-1 group hover:bg-white dark:hover:bg-zinc-800 rounded-full">
                <img height="28px" width="28px" src="{{ Storage::url('public/brands/' . $asicBrand->name . '.webp') }}"
                    alt="{{ $asicBrand->name }}" class="w-5 sm:w-7 mr-2">
                <p
                    class="font-semibold text-gray-600 dark:text-gray-300 text-xs sm:text-sm group-hover:text-gray-900 dark:group-hover:text-gray-200">
                    {{ $asicBrand->name }}
                </p>
            </a>
        @endforeach
    </div>

    <div x-show="show" x-collapse class="grid grid-cols-2 grid-cols-3 md:grid-cols-4 lg:grid-cols-2 gap-1 mt-1">
        @foreach ($asicBrands->slice(6) as $asicBrand)
            <a href="{{ route('database.brand', ['asicBrand' => strtolower(str_replace(' ', '_', $asicBrand->name))]) }}"
                class="h-9 flex items-center px-2 py-1 group hover:bg-white dark:hover:bg-zinc-800 rounded-full">
                <img height="28px" width="28px"
                    src="{{ Storage::url('public/brands/' . $asicBrand->name . '.webp') }}" alt="{{ $asicBrand->name }}"
                    class="w-5 sm:w-7 mr-2">
                <p
                    class="font-semibold text-gray-600 dark:text-gray-300 text-xs sm:text-sm group-hover:text-gray-900 dark:group-hover:text-gray-200">
                    {{ $asicBrand->name }}
                </p>
            </a>
        @endforeach
    </div>

    <button @click="show = !show;" class="px-2 py-1 text-sm mt-2 text-indigo-500 hover:text-indigo-600"
        x-text="!show ? '{{ __('Show all') }}' : '{{ __('Hide') }}'"></button>
</div>
