<section class="mt-4 sm:mt-6 lg:mt-8">
    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
        <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
            {{ __('Offers') }} {{ $brand->name }} {{ $model->name }}
        </h2>
    </div>

    {{-- request()->routeIs('database.asic-miners.model')
                    ? route('database.asic-miners.model.get-ads', ['asicBrand' => $brand->slug, 'asicModel' => $model->slug])
                    : route('database.asic-miners.version.get-ads', [
                        'asicBrand' => $brand->slug,
                        'asicModel' => $model->slug,
                        'asicVersion' => $selectedVersion['h'] . $selectedVersion['m'],
                    ]) --}}

    <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5" id="infinite-loader"
        x-data="{}" x-init="new InfiniteLoader({ endpoint: '{{ route('database.asic-miners.model.get-ads', ['asicBrand' => $brand->slug, 'asicModel' => $model->slug]) }}', page: {{ $ads->currentPage() }}, lastPage: {{ $ads->lastPage() }} });">
        @include('ad.components.list', ['owner' => false])
    </div>
</section>
