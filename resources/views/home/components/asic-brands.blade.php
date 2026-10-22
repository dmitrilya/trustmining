<div x-data="{ show: false }"
    class="transition p-2 sm:p-3 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl">
    <h2 class="text-xs text-slate-500 uppercase tracking-widest mb-4 lg:mb-6">
        {{ __('Brands') }}
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-2 gap-1">
        @foreach ($asicBrands->slice(0, 6) as $asicBrand)
            <a href="{{ route('database.asic-miners.brand', ['asicBrand' => $asicBrand->slug]) }}" class="flex items-center group">
                <img src="{{ Storage::url('public/brands/' . $asicBrand->name . '.webp') }}" alt="{{ $asicBrand->name }} logo" class="w-5 sm:w-7 mr-2">
                <p class="font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-emerald-400">
                    {{ $asicBrand->name }}
                </p>
            </a>
        @endforeach
    </div>

    <div x-show="show" x-collapse x-cloak class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-2 gap-1 mt-1">
        @foreach ($asicBrands->slice(6) as $asicBrand)
            <a href="{{ route('database.asic-miners.brand', ['asicBrand' => $asicBrand->slug]) }}" class="flex items-center group">
                <img src="{{ Storage::url('public/brands/' . $asicBrand->name . '.webp') }}" alt="{{ $asicBrand->name }}" class="w-5 sm:w-7 mr-2">
                <p class="font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-emerald-400">
                    {{ $asicBrand->name }}
                </p>
            </a>
        @endforeach
    </div>

    <button @click="show = !show;" class="text-sm mt-3 text-indigo-500 hover:text-indigo-600"
        x-text="!show ? '{{ __('Show all') }}' : '{{ __('Hide') }}'"></button>
</div>
