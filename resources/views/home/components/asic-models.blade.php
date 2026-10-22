<div x-data="{ show: false }"
    class="transition p-2 sm:p-3 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl ">
    <h2 class="text-xs text-slate-500 uppercase tracking-widest mb-4">
        {{ __('Popular models') }}
    </h2>

    <div class="space-y-2 lg:space-y-3">
        @foreach ($asicModels->slice(0, 5) as $asicModel)
            <a href="{{ route('ads', ['adCategory' => 'miners', 'model' => $asicModel->slug]) }}" class="flex items-center group">
                <img src="{{ Storage::url('public/brands/' . $asicModel->asicBrand->name . '.webp') }}" alt="{{ $asicModel->asicBrand->name }}" class="w-5 mr-2">

                <p class="font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-emerald-400">
                    {{ $asicModel->asicBrand->name }} {{ $asicModel->name }}
                </p>
            </a>
        @endforeach
    </div>

    <div x-show="show" x-collapse x-cloak class="space-y-2 lg:space-y-3 mt-2 lg:mt-3">
        @foreach ($asicModels->slice(5) as $asicModel)
            <a href="{{ route('ads', ['adCategory' => 'miners', 'model' => $asicModel->slug]) }}" class="flex items-center group">
                <img src="{{ Storage::url('public/brands/' . $asicModel->asicBrand->name . '.webp') }}" alt="{{ $asicModel->asicBrand->name }}"
                    class="w-5 mr-2">

                <p class="font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-emerald-400">
                    {{ $asicModel->asicBrand->name }} {{ $asicModel->name }}
                </p>
            </a>
        @endforeach
    </div>

    <button @click="show = !show;" class="text-sm mt-3 text-indigo-500 hover:text-indigo-600"
        x-text="!show ? '{{ __('More') }}' : '{{ __('Hide') }}'"></button>
</div>
