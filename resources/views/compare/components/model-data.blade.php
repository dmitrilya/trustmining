<div
    class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-sm shadow-logo-color rounded-lg p-1 xs:p-2 sm:p-4 lg:p-6 space-y-4 lg:space-y-6">
    @php
        $reviewsCount = $model->moderatedReviews->count();
        $momentRating = $reviewsCount ? $model->moderatedReviews->avg('rating') : 0;
        $modelAds = $ads->where('asic_model_slug', $model->slug);
        $version = $model->data->asicVersions->first();
        $versionWithAds = $modelAds->count()
            ? $model->data->asicVersions
                ->where(
                    'hashrate',
                    $ads->where('price', '!=', 0)->sortByDesc('asic_version_hashrate')->first()->asic_version_hashrate,
                )
                ->first()
            : null;
        if ($versionWithAds) {
            $minPrice = $ads
                ->where('asic_version_hashrate', $versionWithAds->hashrate)
                ->where('price', '!=', 0)
                ->sortBy('price')
                ->first();
        }
    @endphp

    <h2 class="text-lg sm:text-xl lg:text-2xl text-slate-800 dark:text-slate-200 font-bold">{{ $model->data->name }}</h2>
    <x-characteristics>
        <x-characteristic name="Hashrate" :value="$model->data->asicVersions->count() > 1
            ? $model->data->asicVersions->last()->hashrate . '-' . $version->hashrate . ' ' . $version->measurement
            : $version->hashrate . $version->measurement" />
        <x-characteristic name="Algorithm" :value="$model->data->algorithm->name" />
        <x-characteristic name="Efficiency" :value="$version->efficiency . ' j/' . $version->measurement" />
        <x-characteristic name="Release date" :value="$model->data->release->locale(app()->getLocale())->translatedFormat('F Y')" />
        <x-characteristic name="Cooling" :value="$model->characteristics['Cooling']" />
    </x-characteristics>

    @if ($versionWithAds && count($versionWithAds->profits))
        <div>
            <p class="text-xxs xs:text-xs text-slate-500 mb-2">{{ __('Calculation for') }}
                {{ $versionWithAds->hashrate }}{{ $versionWithAds->measurement }}</p>

            @include('ad.components.payback_info', [
                'profit' => $versionWithAds->profits[0]['profit'],
                'expense' => (($versionWithAds->hashrate * $versionWithAds->efficiency * 24) / 1000) * $rub,
                'tariff' => 5,
                'price' => $minPrice->price * $minPrice->coin_rate,
                'cols2' => 'lg:grid-cols-2',
            ])
        </div>

        <x-characteristics>
            <x-characteristic name="Power" :value="$versionWithAds->efficiency * $versionWithAds->hashrate . ' W'" />
            <x-characteristic name="Ads count" :value="$modelAds->count()" />
            @if ($minPrice)
                <x-characteristic name="The best price" :value="$minPrice->price . ' ' . $minPrice->coin" />
            @endif
        </x-characteristics>
    @elseif (count($version->profits))
        <div>
            <p class="text-xxs xs:text-xs text-slate-500 mb-2">{{ __('Calculation for') }}
                {{ $version->hashrate }}{{ $version->measurement }}</p>

            @include('ad.components.payback_info', [
                'profit' => $version->profits[0]['profit'],
                'expense' => (($version->hashrate * $version->efficiency * 24) / 1000) * $rub,
                'tariff' => 5,
                'price' => 0,
                'cols2' => 'lg:grid-cols-2',
            ])
        </div>

        <x-characteristics>
            <x-characteristic name="Power" :value="$version->efficiency * $version->hashrate . ' W'" />
        </x-characteristics>
    @endif
</div>
