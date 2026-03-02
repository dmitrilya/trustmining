<div
    class="px-1 sm:py-3 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl ">
    <h2 class="pt-1 px-3 lg:mb-6 text-base text-slate-700 dark:text-slate-300 font-bold">
        {{ __('Popular models') }}
    </h2>

    <div class="space-y-1">
        @foreach ($asicModels as $asicModel)
            <a href="{{ route('ads', ['adCategory' => 'miners', 'model' => strtolower(str_replace(' ', '_', $asicModel->name))]) }}"
                class="flex items-center px-3 py-2 hover:bg-white dark:hover:bg-slate-800 text-sm text-slate-800 dark:text-slate-200 rounded-full">
                <img height="20px" width="20px"
                    src="{{ Storage::url('public/brands/' . $asicModel->asicBrand->name . '.webp') }}"
                    alt="{{ $asicModel->asicBrand->name }}" class="w-5 mr-2">

                <p
                    class="font-bold text-slate-600 dark:text-slate-300 text-xs sm:text-sm group-hover:text-slate-900 dark:group-hover:text-slate-200">
                    {{ $asicModel->asicBrand->name }} {{ $asicModel->name }}
                </p>
            </a>
        @endforeach
    </div>
</div>
